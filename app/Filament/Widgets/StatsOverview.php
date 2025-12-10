<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Mengatur urutan tampilan di dashboard (opsional)
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Hitung Total User
        // Kita cek dulu: Apakah user yang login boleh melihat daftar user?
        // Jika Super Admin (via Gate) atau Sub Admin (via Permission), ini akan True.
        $totalUsers = auth()->user()->can('manage_users') 
            ? User::count() 
            : 0;

        // 2. Hitung Role
        $totalRoles = auth()->user()->can('manage_roles') 
            ? Role::count() 
            : 0;

        // 3. Hitung Permission
        $totalPermissions = auth()->user()->can('manage_permissions') 
            ? Permission::count() 
            : 0;

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Pengguna terdaftar ↗')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'), // Warna hijau

            Stat::make('Roles', $totalRoles)
                ->description('Jabatan tersedia 🛡')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'), // Warna biru

            Stat::make('Permissions', $totalPermissions)
                ->description('Hak akses sistem 🔑')
                ->descriptionIcon('heroicon-m-key')
                ->color('warning'), // Warna oranye
        ];
    }

    // [TAMBAHKAN INI]
    // Fungsi ini menentukan siapa yang boleh melihat widget ini
    public static function canView(): bool
    {
        // Hanya tampil jika user punya Role 'Super Admin' atau 'Sub Admin'
        return auth()->user()->hasAnyRole(['Super Admin', 'Sub Admin']);
    }

}