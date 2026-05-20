<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\Service;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.website', function ($view) {
            static $companySetting;

            $companySetting ??= CompanySetting::latest()->first();

            $view->with([
                'websiteCompanySetting' => $companySetting,
                'websiteCompanyName' => 'Multitechwave',
            ]);
        });

        View::composer([
            'partials.website.header',
            'partials.website.footer',
            'partials.website.floating-contact',
        ], function ($view) {
            static $companySetting;
            static $services;

            $companySetting ??= CompanySetting::latest()->first();
            $services ??= Service::with('detail')->orderBy('order')->latest()->get();

            $view->with([
                'websiteCompanySetting' => $companySetting,
                'websiteServices' => $services,
            ]);
        });
    }
}
