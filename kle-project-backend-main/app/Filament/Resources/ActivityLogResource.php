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

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

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
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (!$state || !is_array($state))
                            return null;

                        $mapping = [
                            'title' => 'Başlık',
                            'content' => 'Açıklama',
                            'image_url' => 'Fotoğraf',
                            'category_id' => 'Kategori',
                            'user_id' => 'Kullanıcı',
                            'is_approved' => 'Onay Durumu',
                            'slug' => 'URL Takısı',
                            'name' => 'Ad',
                            'email' => 'E-posta',
                        ];

                        $output = "";
                        if (isset($state['old']) && isset($state['new'])) {
                            foreach ($state['new'] as $key => $value) {
                                if ($key === 'updated_at')
                                    continue;
                                $label = $mapping[$key] ?? $key;
                                $oldValue = $state['old'][$key] ?? '-';
                                $newValue = $value ?? '-';
                                $output .= "{$label}: {$oldValue} -> {$newValue}\n";
                            }
                        } else {
                            foreach ($state as $key => $value) {
                                if (in_array($key, ['created_at', 'updated_at', 'id']))
                                    continue;
                                $label = $mapping[$key] ?? $key;
                                $output .= "{$label}: " . (is_array($value) ? json_encode($value) : $value) . "\n";
                            }
                        }

                        return $output ?: null;
                    })
                    ->formatStateUsing(function ($state) {
                        if (!$state || !is_array($state)) {
                            return '-';
                        }

                        $mapping = [
                            'title' => 'Başlık',
                            'content' => 'Açıklama',
                            'image_url' => 'Fotoğraf',
                            'category_id' => 'Kategori',
                            'user_id' => 'Kullanıcı',
                            'is_approved' => 'Onay Durumu',
                            'name' => 'Ad',
                            'email' => 'E-posta',
                        ];

                        if (isset($state['old']) && isset($state['new'])) {
                            $fields = array_keys($state['new']);
                            $labels = [];
                            foreach ($fields as $field) {
                                if ($field === 'updated_at')
                                    continue;
                                $labels[] = ($mapping[$field] ?? $field) . ' düzenlendi';
                            }
                            return implode(', ', $labels) ?: 'Güncellendi';
                        }

                        $fields = array_keys($state);
                        $labels = [];
                        foreach ($fields as $field) {
                            if (in_array($field, ['created_at', 'updated_at', 'id']))
                                continue;
                            $labels[] = ($mapping[$field] ?? $field) . ' eklendi';
                        }
                        return implode(', ', $labels) ?: 'İşlem yapıldı';
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
