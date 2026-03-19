<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Models\Food;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $navigationLabel = 'Alimentos';

    protected static ?string $modelLabel = 'alimento';

    protected static ?string $pluralModelLabel = 'alimentos';

    protected static ?string $navigationGroup = 'Gestión';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('trainer_id')->default(fn () => auth()->id()),
                Section::make('Ficha del alimento')
                    ->schema([
                        TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                        TextInput::make('brand')->label('Marca')->maxLength(255),
                        TextInput::make('serving_reference')
                            ->label('Referencia')
                            ->helperText('Ejemplo: valores por 100 g o por unidad.')
                            ->default('100 g')
                            ->required()
                            ->maxLength(60),
                        Toggle::make('is_active')->label('Disponible')->default(true),
                        Textarea::make('notes')->label('Notas')->rows(3)->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Información nutricional')
                    ->description('Introduce los macronutrientes de referencia para usar este alimento dentro de dietas.')
                    ->schema([
                        TextInput::make('calories_kcal')->label('Calorías (kcal)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('protein_g')->label('Proteínas (g)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('carbs_g')->label('Carbohidratos (g)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('fat_g')->label('Grasas (g)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('fiber_g')->label('Fibra (g)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('sugar_g')->label('Azúcares (g)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('sodium_mg')->label('Sodio (mg)')->numeric()->required()->default(0)->minValue(0),
                        TextInput::make('source')->label('Origen')->default('manual')->required()->maxLength(50),
                        TextInput::make('external_id')->label('ID externo')->maxLength(120),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')->label('Nombre')->searchable(['name', 'brand'])->sortable(),
                TextColumn::make('brand')->label('Marca')->searchable()->toggleable(),
                TextColumn::make('serving_reference')->label('Valores por')->badge()->color('gray'),
                TextColumn::make('calories_kcal')->label('Kcal')->numeric(decimalPlaces: 0)->sortable(),
                TextColumn::make('protein_g')->label('Prot')->suffix(' g')->numeric(decimalPlaces: 1),
                TextColumn::make('carbs_g')->label('Carbs')->suffix(' g')->numeric(decimalPlaces: 1),
                TextColumn::make('fat_g')->label('Grasas')->suffix(' g')->numeric(decimalPlaces: 1),
                TextColumn::make('source')->label('Origen')->badge(),
                IconColumn::make('is_active')->label('Activo')->boolean(),
            ])
            ->actions([
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
            'index' => Pages\ManageFoods::route('/'),
        ];
    }
}
