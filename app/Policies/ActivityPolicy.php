<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    /**
     * Tentukan apakah user bisa melihat daftar log (Menu Activities).
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_activities');
    }

    /**
     * Tentukan apakah user bisa melihat detail satu log.
     */
    public function view(User $user, Activity $activity): bool
    {
        return $user->can('manage_activities');
    }

    /**
     * Log tidak boleh dibuat manual lewat dashboard.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Log adalah catatan sejarah, tidak boleh diedit.
     */
    public function update(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Log tidak boleh dihapus demi keamanan audit.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Log tidak boleh di-restore.
     */
    public function restore(User $user, Activity $activity): bool
    {
        return false;
    }
}