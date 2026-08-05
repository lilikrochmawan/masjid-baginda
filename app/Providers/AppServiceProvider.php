<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

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
        View::composer('*', function ($view) {
            try {
                $setting = Schema::hasTable('tb_setting') ? Setting::first() : null;
                $logoFavicon = $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('images/image.png');
            } catch (\Exception $e) {
                $logoFavicon = asset('images/image.png');
            }
            $view->with('logoFavicon', $logoFavicon);
        });
    }
}
