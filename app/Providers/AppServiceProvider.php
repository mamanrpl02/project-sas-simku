<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Model::unguard();

        Gate::define('access-export', function (User $user) {
            return true; // Semua user yang sudah login bisa mengakses
        });

        Gate::define('access-idGroup', function (User $user) {
            return true; // Semua user yang sudah login bisa mengakses
        });
    }
}
