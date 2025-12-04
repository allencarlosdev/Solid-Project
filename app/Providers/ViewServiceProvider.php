<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share user collections with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userCollections = Auth::user()->bookCollections()->withCount('books')->get();
                $view->with('userCollections', $userCollections);
            }
        });
    }
}
