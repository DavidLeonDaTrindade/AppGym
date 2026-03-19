<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietResource\Pages;
use App\Models\ClientDiet;
use App\Models\Diet;
use App\Models\Food;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DietResource extends Resource
{
    protected static ?string $model = Diet::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Dietas';

    protected static ?string $modelLabel = 'dieta';

    protected static ?string $pluralModelLabel = 'dietas';

    protected static ?string $navigationGroup = 'Planificación';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('trainer_id')->default(fn () => auth()->id()),
                Section::make('Información general')
                    ->schema([
                        TextInput::make('title')->label('Título')->required()->maxLength(255),
                        Textarea::make('summary')->label('Resumen')->rows(3),
                        Toggle::make('is_active')->label('Disponible')->default(true),
                        Textarea::make('content')->label('Plan recomendado')->rows(10)->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Alimentos de la dieta')
                    ->description('Construye la dieta usando alimentos del catálogo. Los macronutrientes se calculan según la cantidad indicada.')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->reorderableWithButtons()
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['meal_slot'] ?? null)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Orden')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(0),
                                TextInput::make('meal_slot')
                                    ->label('Comida')
                                    ->placeholder('Desayuno, almuerzo, cena...')
                                    ->maxLength(120),
                                Select::make('food_id')
                                    ->label('Alimento')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->options(fn () => Food::query()
                                        ->where('trainer_id', auth()->id())
                                        ->where('is_active', true)
                                        ->orderBy('name')
                                        ->get()
                                        ->mapWithKeys(fn (Food $food) => [
                                            $food->id => sprintf(
                                                '%s (%s kcal / %s)',
                                                $food->name,
                                                number_format((float) $food->calories_kcal, 0),
                                                $food->serving_reference
                                            ),
                                        ]))
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set): void {
                                        self::syncNutritionalSnapshot($get, $set);
                                    }),
                                TextInput::make('quantity_grams')
                                    ->label('Cantidad (g)')
                                    ->numeric()
                                    ->default(100)
                                    ->minValue(0)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set): void {
                                        self::syncNutritionalSnapshot($get, $set);
                                    }),
                                TextInput::make('servings')
                                    ->label('Raciones')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(0)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set): void {
                                        self::syncNutritionalSnapshot($get, $set);
                                    }),
                                TextInput::make('calories_kcal')->label('Kcal calculadas')->numeric()->readOnly()->dehydrated(),
                                TextInput::make('protein_g')->label('Proteínas (g)')->numeric()->readOnly()->dehydrated(),
                                TextInput::make('carbs_g')->label('Carbohidratos (g)')->numeric()->readOnly()->dehydrated(),
                                TextInput::make('fat_g')->label('Grasas (g)')->numeric()->readOnly()->dehydrated(),
                                TextInput::make('fiber_g')->label('Fibra (g)')->numeric()->readOnly()->dehydrated(),
                                Placeholder::make('food_reference')
                                    ->label('Referencia nutricional')
                                    ->content(function (Get $get): string {
                                        $foodId = $get('food_id');

                                        if (! $foodId) {
                                            return 'Selecciona un alimento para ver su referencia.';
                                        }

                                        $food = Food::query()->where('trainer_id', auth()->id())->find($foodId);

                                        return $food
                                            ? sprintf(
                                                '%s | %s kcal | P %sg | C %sg | G %sg',
                                                $food->serving_reference,
                                                number_format((float) $food->calories_kcal, 0),
                                                number_format((float) $food->protein_g, 1),
                                                number_format((float) $food->carbs_g, 1),
                                                number_format((float) $food->fat_g, 1),
                                            )
                                            : 'Alimento no disponible.';
                                    }),
                                Textarea::make('notes')->label('Notas')->rows(3)->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('summary')->label('Resumen')->limit(45),
                TextColumn::make('items_count')->label('Alimentos')->counts('items'),
                IconColumn::make('is_active')->label('Activa')->boolean(),
                TextColumn::make('updated_at')->label('Actualizada')->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('assign')
                    ->label('Asignar')
                    ->icon('heroicon-o-link')
                    ->form([
                        \Filament\Forms\Components\Select::make('client_ids')
                            ->label('Clientes')
                            ->multiple()
                            ->required()
                            ->options(fn () => User::query()
                                ->where('role', User::ROLE_CLIENT)
                                ->where('trainer_id', auth()->id())
                                ->orderBy('name')
                                ->pluck('name', 'id')),
                        DatePicker::make('starts_at')->label('Inicio'),
                        DatePicker::make('ends_at')->label('Fin'),
                        Textarea::make('notes')->label('Notas')->rows(3),
                    ])
                    ->action(function (Diet $record, array $data): void {
                        $trainer = auth()->user();

                        $clientIds = User::query()
                            ->where('role', User::ROLE_CLIENT)
                            ->where('trainer_id', $trainer->id)
                            ->whereIn('id', $data['client_ids'] ?? [])
                            ->pluck('id');

                        foreach ($clientIds as $clientId) {
                            ClientDiet::create([
                                'trainer_id' => $trainer->id,
                                'client_id' => $clientId,
                                'diet_id' => $record->id,
                                'starts_at' => $data['starts_at'] ?? null,
                                'ends_at' => $data['ends_at'] ?? null,
                                'notes' => $data['notes'] ?? null,
                                'is_active' => true,
                            ]);
                        }

                        Notification::make()
                            ->title('Dieta asignada correctamente')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('trainer_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDiets::route('/'),
        ];
    }

    protected static function syncNutritionalSnapshot(Get $get, Set $set): void
    {
        $foodId = $get('food_id');
        $quantity = max((float) ($get('quantity_grams') ?: 0), 0);
        $servings = max((float) ($get('servings') ?: 0), 0);

        if (! $foodId) {
            foreach (['calories_kcal', 'protein_g', 'carbs_g', 'fat_g', 'fiber_g'] as $field) {
                $set($field, 0);
            }

            return;
        }

        $food = Food::query()
            ->where('trainer_id', auth()->id())
            ->find($foodId);

        if (! $food) {
            return;
        }

        $multiplier = ($quantity / 100) * ($servings > 0 ? $servings : 1);

        $set('calories_kcal', round((float) $food->calories_kcal * $multiplier, 2));
        $set('protein_g', round((float) $food->protein_g * $multiplier, 2));
        $set('carbs_g', round((float) $food->carbs_g * $multiplier, 2));
        $set('fat_g', round((float) $food->fat_g * $multiplier, 2));
        $set('fiber_g', round((float) $food->fiber_g * $multiplier, 2));
    }
}
