<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietResource\Pages;
use App\Models\ClientDiet;
use App\Models\Diet;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
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
                TextInput::make('title')->label('Título')->required()->maxLength(255),
                Textarea::make('summary')->label('Resumen')->rows(3),
                Textarea::make('content')->label('Plan recomendado')->rows(10)->columnSpanFull(),
                Toggle::make('is_active')->label('Disponible')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('summary')->label('Resumen')->limit(45),
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
}
