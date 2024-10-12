<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Route::macro('softDeletes', function ($uri, $controller) {
            Route::get("$uri/trashed", [$controller, 'trashed'])->name("$uri.trashed");
            Route::patch("$uri/{user}/restore", [$controller, 'restore'])->name("$uri.restore");
            Route::delete("$uri/{user}/delete", [$controller, 'forceDelete'])->name("$uri.force-delete");
        });
    }
}