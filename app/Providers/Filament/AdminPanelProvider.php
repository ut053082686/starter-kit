<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color; // Import Color
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Enums\ThemeMode; // Import untuk mode gelap/terang

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            
            // --- 1. LOGIN & REGISTRASI ---
            ->login(CustomLogin::class) // Halaman login default
            //->registration() // Opsi: Aktifkan jika Starter Kit butuh register mandiri
            //->passwordReset() // Opsi: Lupa password
            //->emailVerification() // Opsi: Verifikasi email
            ->profile(isSimple: false) // Profil (kita sudah punya custom, tapi ini untuk menu user)

            // --- 2. WARNA TEMA (TAILWIND) ---
            // Gunakan warna 'Indigo' atau 'Sky' agar terlihat modern & techy
            // Hindari warna default 'Amber'/'Blue' jika ingin terlihat beda.
            ->colors([
                'primary' => Color::Indigo, // Warna utama tombol & link
                'gray' => Color::Slate, // Warna teks & background (Slate lebih kebiruan/modern)
            ])
            
            // --- 3. LOGO & NAMA APLIKASI ---
            ->brandName('Starter Kit v1') // Nama teks jika logo gagal load
            ->brandLogo(asset('images/logo-light.svg')) // Logo untuk mode terang
            ->darkModeBrandLogo(asset('images/logo-dark.svg')) // Logo untuk mode gelap
            ->brandLogoHeight('3rem') // Ukuran tinggi logo (sesuaikan)
            ->favicon(asset('images/favicon.svg')) // Ikon di tab browser
            
            // --- 4. TAMPILAN SIDEBAR ---
            ->sidebarCollapsibleOnDesktop() // Sidebar bisa dilipat (hemat ruang)
            ->collapsibleNavigationGroups(true) // Grup menu bisa di-collapse
            
            // --- 5. FONT (Opsional tapi Keren) ---
            // Filament v3+ defaultnya pakai font sistem. 
            // Anda bisa load font Google (misal: Poppins) via CSS terpisah,
            // atau gunakan font() jika sudah setup Vite.
            ->font('Poppins') 

            // --- 6. KONFIGURASI LAINNYA (DEFAULT) ---
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class, // Matikan ini jika sudah punya Custom Stats
                // Widgets\FilamentInfoWidget::class, // Matikan info Filament default
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}