<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // <--- Jangan lupa baris ini!
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable() // Agar bisa dicari
                    ->sortable(),  // Agar bisa diurutkan
                
                TextColumn::make('email')
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyi secara default

                TextColumn::make('roles.name') // Mengambil nama role
                    ->badge() // Membuat tampilannya seperti label/lencana warna-warni
                    ->color(fn (string $state): string => match ($state) {
                        'Super Admin' => 'danger', // Merah untuk Admin
                        'Sub Admin' => 'success', // Hijau untuk Admin
                        'User' => 'info',        // Biru untuk User
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                            BulkActionGroup::make([
                                DeleteBulkAction::make()
                                    ->action(function (Collection $records) {
                                        foreach ($records as $record) {
                                            // Jika ID record adalah 1 ATAU record punya role Super Admin
                                            if ($record->id === 1 || $record->hasRole('Super Admin')) {
                                                
                                                Notification::make()
                                                    ->title('Gagal: Akun Dilindungi')
                                                    ->body('Aksi dibatalkan. Ada akun Super Admin atau ID 1 yang terpilih.')
                                                    ->danger()
                                                    ->send();

                                                return;
                                            }
                                        }

                                        // Jika lolos pengecekan, hapus semua
                                        $records->each->delete();
                                    }),
                            ]),
                        ]);
    }
}