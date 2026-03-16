<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientRoutineResource\Pages;
use App\Models\ClientRoutine;
use App\Models\Routine;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientRoutineResource extends Resource
{
    protected static ?string $model = ClientRoutine::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Asignaciones de rutina';

    protected static ?string $modelLabel = 'asignación de rutina';

    protected static ?string $pluralModelLabel = 'asignaciones de rutina';

    protected static ?string $navigationGroup = 'Seguimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('trainer_id')->default(fn () => auth()->id()),
                Select::make('client_id')
                    ->label('Cliente')
                    ->required()
                    ->options(fn () => User::query()
                        ->where('role', User::ROLE_CLIENT)
                        ->where('trainer_id', auth()->id())
                        ->orderBy('name')
                        ->pluck('name', 'id')),
                Select::make('routine_id')
                    ->label('Rutina')
                    ->required()
                    ->options(fn () => Routine::query()
                        ->where('trainer_id', auth()->id())
                        ->orderBy('title')
                        ->pluck('title', 'id')),
                DatePicker::make('starts_at')->label('Inicio'),
                DatePicker::make('ends_at')->label('Fin'),
                Toggle::make('is_active')->label('Activa')->default(true),
                Textarea::make('notes')->label('Notas')->rows(3)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')->label('Cliente')->searchable(),
                TextColumn::make('routine.title')->label('Rutina')->searchable(),
                TextColumn::make('starts_at')->label('Inicio')->date('d/m/Y'),
                TextColumn::make('ends_at')->label('Fin')->date('d/m/Y'),
                IconColumn::make('is_active')->label('Activa')->boolean(),
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
            'index' => Pages\ManageClientRoutines::route('/'),
        ];
    }
}
