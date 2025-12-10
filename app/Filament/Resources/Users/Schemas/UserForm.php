<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Select::make('roles')
                    ->relationship(
                        name: 'roles',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => auth()->user()->hasRole('Super Admin') 
                            ? $query 
                            : $query->where('name', '!=', 'Super Admin')
                    )
                    ->multiple()
                    ->preload()
                    ->searchable()
                    // [PATCH] Matikan input saat Edit jika bukan Super Admin
                    ->disabled(fn (string $operation) => $operation === 'edit' && ! auth()->user()->hasRole('Super Admin')),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state)),
            ]);
    }
}