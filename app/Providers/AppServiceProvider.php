<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Lote;
use App\Observers\LoteObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void { /* ... */ }

    public function boot(): void
    {
        // Vinculación vital
        Lote::observe(LoteObserver::class);
    }
}