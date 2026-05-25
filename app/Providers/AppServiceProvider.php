<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\Service;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('ai-call-leads', function (Request $request) {
            $rateLimitedResponse = function (Request $request, array $headers) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Too many AI call lead requests. Please try again shortly.',
                ], 429, $headers);
            };

            return [
                Limit::perMinute(60)
                    ->by('ai-call-leads:minute:'.$request->ip())
                    ->response($rateLimitedResponse),
                Limit::perHour(1000)
                    ->by('ai-call-leads:hour:'.$request->ip())
                    ->response($rateLimitedResponse),
            ];
        });

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
