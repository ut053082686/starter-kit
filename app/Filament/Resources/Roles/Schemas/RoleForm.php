<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList; // [1] Tambahkan ini

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                // [2] Tambahkan daftar checklist Permission di sini
                CheckboxList::make('permissions')
                    ->relationship('permissions', 'name') // Hubungkan ke tabel permissions
                    ->searchable() // Agar mudah dicari jika permission-nya banyak
                    ->columns(2) // Tampilkan dalam 2 kolom agar rapi
                    ->bulkToggleable(), // Tombol "Pilih Semua"
            ]);
    }
}