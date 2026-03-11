<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Yönetim';

    protected static ?string $label = 'Sistem Kayıtları';

    protected static ?string $pluralLabel = 'Sistem Kayıtları';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('İşlem')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Eklendi' => 'success',
                        'Güncellendi' => 'warning',
                        'Silindi' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Açıklama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Tür')
                    ->formatStateUsing(fn($state) => class_basename($state)),
                Tables\Columns\TextColumn::make('properties')
                    ->label('Değişiklik Özeti')
                    ->limit(50)
                    ->tooltip(fn(Tables\Columns\TextColumn $column): ?string => $column->getState() ? json_encode($column->getState(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : null)
                    ->formatStateUsing(function ($state) {
                        if (!$state)
                            return '-';
                        if (isset($state['old']) && isset($state['new'])) {
                            return 'Değişim: ' . count($state['new']) . ' alan';
                        }
                        return count($state) . ' veri';
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
