<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // [1] Import Gate
use Spatie\Activitylog\Models\Activity; // [2] Import Model Activity Spatie
use App\Policies\ActivityPolicy; // [3] Import Policy yang baru kita buat

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // [4] Daftarkan Policy secara eksplisit
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}