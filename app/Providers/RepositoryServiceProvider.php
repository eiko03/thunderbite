<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * singleton binding so that, there is only one instance throughout the application
         */
        $this->app->singleton('App\Repositories\Interfaces\SymbolRepositoryInterface', 'App\Repositories\Classes\SymbolRepository');
        $this->app->singleton('App\Repositories\Interfaces\GameRepositoryInterface', 'App\Repositories\Classes\GameRepository');
        $this->app->singleton('App\Repositories\Interfaces\CampaignRepositoryInterface', 'App\Repositories\Classes\CampaignRepository');
    }
}
