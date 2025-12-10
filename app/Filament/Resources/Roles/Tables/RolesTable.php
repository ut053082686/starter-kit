<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // [1] Jangan lupa import ini!

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // [2] Menambahkan kolom Nama Role
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                // [3] Menambahkan kolom Tanggal Dibuat (opsional, disembunyikan default)
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}