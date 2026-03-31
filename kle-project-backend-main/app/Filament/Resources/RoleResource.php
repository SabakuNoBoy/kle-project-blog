<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Roller';
    protected static ?string $modelLabel = 'Rol';
    protected static ?string $pluralModelLabel = 'Roller';
    protected static ?string $navigationGroup = 'Yönetim';
    protected static ?int $navigationSort = 10;


    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Rol Adı')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Select::make('permissions')
                ->label('İzinler')
                ->multiple()
                ->relationship('permissions', 'name')
                ->preload()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Rol Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('permissions.name')
                    ->label('İzinler')
                    ->badge()
                    ->color('success')
                    ->separator(','),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
