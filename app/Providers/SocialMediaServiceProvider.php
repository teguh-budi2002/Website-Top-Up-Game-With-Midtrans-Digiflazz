<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SocialMediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (Schema::hasTable('social_media')) {
            $socialMedia = DB::table('social_media')
                          ->select('instagram', 'whatsapp', 'facebook', 'email')
                          ->first();
    
            $this->app->singleton('social_media', function () use ($socialMedia) {
                return $socialMedia ?? (object)[
                    'instagram'  => '',
                    'whatsapp'   => '',
                    'facebook'   => '',
                    'email'      => '',
                ];
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
