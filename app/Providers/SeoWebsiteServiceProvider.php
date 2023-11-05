<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SeoWebsiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (Schema::hasTable('seo_website')) {
            $seoData = DB::table('seo_website')
                          ->select('name_of_the_company', 'keyword', 'description', 'logo_favicon', 'logo_website')
                          ->first();
    
            $this->app->singleton('seo_data', function () use ($seoData) {
                return $seoData ?? (object)[
                    'name_of_the_company'   => 'Guh SHOP',
                    'keyword'               => 'Top Up Game Murah, Joki Mobile Legend dan Layanan Booster Social Media, Instant 24 Jam, Mobile Legends, Diamond Mobile Legends, Free Fire, DM FF,  Mobile, PUBGM, Genshin Impact, CODM, Valorant, Wild Rift',
                    'description'           => 'Website Top Up Termurah Se-Indonesia.',
                    'logo_favicon'          => '',
                    'logo_website'          => '',
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
