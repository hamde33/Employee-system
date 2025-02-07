<?php

namespace App\Providers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

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
    public function boot()
    {
        // ضبط اللغة بناءً على الجلسة
        $locale = Session::get('locale', 'en');
        App::setLocale($locale);
    }
}
