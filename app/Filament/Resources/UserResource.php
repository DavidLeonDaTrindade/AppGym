<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $modelLabel = 'cliente';

    protected static ?string $pluralModelLabel = 'clientes';

    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('role')->default(User::ROLE_CLIENT),
                Hidden::make('trainer_id')->default(fn () => auth()->id()),
                Section::make('Cuenta')
                    ->schema([
                        TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                        TextInput::make('email')->label('Email')->email()->required()->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                        Toggle::make('is_active')->label('Cuenta activa')->default(true),
                        Textarea::make('notes')->label('Notas')->rows(4)->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Datos físicos iniciales')
                    ->description('Todos los campos aceptan el valor 0 si aún no tienes la medición.')
                    ->schema([
                        TextInput::make('age')->label('Edad')->numeric()->minValue(0)->default(0),
                        TextInput::make('training_years')->label('Años entrenando')->numeric()->minValue(0)->default(0),
                        TextInput::make('height_cm')->label('Altura (cm)')->numeric()->minValue(0)->default(0),
                        TextInput::make('weight_kg')->label('Peso (kg)')->numeric()->minValue(0)->default(0),
                        TextInput::make('body_mass_index')->label('IMC')->numeric()->minValue(0)->default(0),
                        TextInput::make('muscle_mass_index')->label('Índice masa muscular')->numeric()->minValue(0)->default(0),
                        TextInput::make('body_fat_percentage')->label('% grasa corporal')->numeric()->minValue(0)->default(0),
                        TextInput::make('muscle_mass_kg')->label('Masa muscular (kg)')->numeric()->minValue(0)->default(0),
                        TextInput::make('goal_weight_kg')->label('Peso objetivo (kg)')->numeric()->minValue(0)->default(0),
                        TextInput::make('waist_cm')->label('Cintura (cm)')->numeric()->minValue(0)->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('weight_kg')->label('Peso')->suffix(' kg')->sortable(),
                TextColumn::make('body_fat_percentage')->label('% grasa')->suffix('%')->sortable(),
                IconColumn::make('is_active')->label('Activa')->boolean(),
                TextColumn::make('created_at')->label('Alta')->date('d/m/Y')->sortable(),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', User::ROLE_CLIENT)
            ->where('trainer_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
