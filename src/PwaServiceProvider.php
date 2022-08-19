<?php

namespace LdTalent\Pwa;

use Illuminate\Support\ServiceProvider;

use LdTalent\Pwa\Commands\PublishPwaAssets;

class PwaServiceProvider extends ServiceProvider
{
	
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
	{

	}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->singleton('pwa-laravel:publish', function ($app) {
    		return new PublishPwaAssets();
    	});

    	$this->commands([
    		'pwa-laravel:publish',
    	]);
    }

}