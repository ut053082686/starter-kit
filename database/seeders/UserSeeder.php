<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Permission (Agar tidak hilang saat reset DB)
        // Kita gunakan firstOrCreate agar aman
        $p1 = Permission::firstOrCreate(['name' => 'manage_users']);
        $p2 = Permission::firstOrCreate(['name' => 'manage_roles']);
        $p3 = Permission::firstOrCreate(['name' => 'manage_permissions']);
        $p4 = Permission::firstOrCreate(['name' => 'manage_activities']); // Audit Log

        // 2. Buat Role
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $roleSubAdmin   = Role::firstOrCreate(['name' => 'Sub Admin']);
        $roleUser       = Role::firstOrCreate(['name' => 'User']);

        // 3. Setup Role Permissions (Opsional, jika tidak pakai Gate Super Admin)
        // Sub Admin boleh kelola user[$p1] & role[$p2], tapi tidak boleh lihat audit log
        $roleSubAdmin->givePermissionTo([$p1]); 
        
        // Super Admin tidak perlu di-assign permission manual 
        // JIKA Anda sudah pasang Gate::before di AppServiceProvider.

        // 4. Buat User: Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($roleSuperAdmin);

        // 5. Buat User: Sub Admin
        $subAdmin = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $subAdmin->assignRole($roleSubAdmin);

        // 6. Buat User: User Biasa
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole($roleUser);
    }
}