<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Tự động ép HTTPS khi chạy trên môi trường online/production hoặc proxy (như Railway)
        $isLocalhost = isset($_SERVER['HTTP_HOST']) && in_array(explode(':', $_SERVER['HTTP_HOST'])[0], ['localhost', '127.0.0.1'], true);
        if (!$isLocalhost) {
            URL::forceScheme('https');
        }
    }
}
