<?php

namespace ddkits\sitemap;

use Illuminate\Support\ServiceProvider;

class DdkitsSitemap extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Load the config file and merge it with the user's (should it get published)
        $this->mergeConfigFrom(__DIR__ . '/Config/sitemapConfig.php', 'sitemapConfig');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Allow your user to publish the config
        $this->publishes([
            __DIR__ . '/Config/sitemapConfig.php' => config_path('sitemapConfig.php'),
        ], 'config');
    }
}
