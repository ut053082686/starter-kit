<?php

namespace App\Filament\Pages\Auth;

// [PERBAIKAN] Gunakan namespace yang benar untuk versi ini
use Filament\Auth\Pages\Login; 
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;

class CustomLogin extends Login
{
    // Mengubah Judul Halaman (Browser Title)
    public function getTitle(): string | Htmlable
    {
        return __('Masuk ke Aplikasi');
    }
    
    // Mengubah Heading (Teks Besar di atas form)
    public function getHeading(): string | Htmlable
    {
        return __('Selamat Datang Kembali');
    }

    // (Opsional) Jika Anda ingin form login standar tanpa modifikasi field,
    // Anda bisa menghapus method getForms() ini agar menggunakan bawaan.
    // Jika ingin custom field, pastikan method ini benar.
}