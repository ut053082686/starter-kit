<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // [Patch] Jika target yang diedit adalah Super Admin
        if ($model->hasRole('Super Admin')) {
            // Hanya boleh diedit oleh Super Admin sendiri
            return $user->hasRole('Super Admin');
        }

        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // [Patch] Proteksi agar Super Admin tidak bisa dihapus sembarangan
        if ($model->hasRole('Super Admin')) {
            return $user->hasRole('Super Admin');
        }

        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        if ($model->hasRole('Super Admin')) {
            return $user->hasRole('Super Admin');
        }

        return $user->hasPermissionTo('manage_users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($model->hasRole('Super Admin')) {
            return $user->hasRole('Super Admin');
        }

        return $user->hasPermissionTo('manage_users');
    }
}