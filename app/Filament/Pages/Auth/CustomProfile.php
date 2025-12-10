<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class CustomProfile extends BaseEditProfile
{
    // Cocokkan signature dengan parent (Schema)
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                FileUpload::make('avatar_url')
                    ->label('Foto Profil')
                    ->avatar()
                    ->imageEditor()
                    ->directory('avatars')
                    ->rules(['nullable', 'image', 'max:1024'])
                    ->columnSpanFull(),

                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    // Ubah data sebelum disimpan (ambil path dari array jika FileUpload mengembalikan array)
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['avatar_url']) && is_array($data['avatar_url'])) {
            $data['avatar_url'] = array_values($data['avatar_url'])[0] ?? null;
        }

        return $data;
    }

    // Setelah sukses simpan, tampilkan notifikasi dan refill form
    protected function afterSave(): void
    {
        Notification::make()
            ->title('Profil berhasil disimpan')
            ->success()
            ->send();

        $this->form->fill();
    }
}