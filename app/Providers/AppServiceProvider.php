<?php

namespace App\Providers;
// Ces deux lignes ci-dessous sont cruciales :
use App\Services\VenteService;
use App\Services\ApprovisionnementService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // On force Laravel à lier le service VenteService
        $this->app->singleton(VenteService::class, function ($app) {
            return new VenteService();
        });

        // On force Laravel à lier le service ApprovisionnementService
        $this->app->singleton(ApprovisionnementService::class, function ($app) {
            return new ApprovisionnementService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force le HTTPS si l'application est sur Render (en production)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
