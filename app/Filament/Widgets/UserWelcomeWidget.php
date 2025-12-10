<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class UserWelcomeWidget extends Widget
{
    // [PERBAIKAN] Hapus kata 'static'. Ini harus properti biasa.
    protected string $view = 'filament.widgets.user-welcome-widget';

    // [PERBAIKAN] Hapus kata 'static' di sini juga.
    protected int | string | array $columnSpan = 'full';

    // Method canView() TETAP static (ini pengecualian)
    public static function canView(): bool
    {
        return auth()->user()->hasRole('User');
    }
}