<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar la implementación de BookApiInterface
        $this->app->bind(
            \App\Contracts\BookApiInterface::class,
            \App\Services\GoogleBooksApiService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        // Share user collections with navigation across all views
        view()->composer('layouts.navigation', function ($view) {
            if (auth()->check()) {
                $userCollections = auth()->user()->bookCollections()->withCount('books')->get();
                $view->with('userCollections', $userCollections);
            }
        });
    }
}
