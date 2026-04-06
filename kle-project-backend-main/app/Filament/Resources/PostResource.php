<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('image_url')
                    ->label('Yazı Görseli')
                    ->image()
                    ->directory('posts')
                    ->default('posts/default.svg')
                    ->maxSize(20480)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', str($state)->slug())),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Post::class, 'slug', ignoreRecord: true),
                Forms\Components\RichEditor::make('content')
                    ->label('İçerik')
                    ->required()
                    ->fileAttachmentsDirectory('posts')
                    ->fileAttachmentsVisibility('public')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Onaylandı mı?')
                    ->default(false)
                    ->disabled(fn() => !auth()->user()->hasRole('admin')),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Görsel')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Author'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Approved'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
