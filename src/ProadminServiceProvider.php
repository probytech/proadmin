<?php

namespace Probytech\Proadmin;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Probytech\Proadmin\Services\CollectionService;
use Probytech\Proadmin\Services\LanguageService;
use Probytech\Proadmin\Services\SingleService;

class ProadminServiceProvider extends ServiceProvider
{
    // public $singletons = [
    //  'lang' 		    => LanguageService::class,
	// 	'single' 	    => SingleService::class,
	// 	'collection' 	=> CollectionService::class,
    // ];

	public function boot()
	{
		Schema::defaultStringLength(191);

		if ($this->app->runningInConsole()) {
			$this->commands([
				\Probytech\Proadmin\Commands\ProadminInstall::class,
			]);
		}

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'proadmin');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');

        $this->publishes([
            __DIR__.'/../config/lfm.php' => base_path('config/lfm.php'),
        ], 'proadmin-lfm-config');

        $this->publishes([
            __DIR__.'/../config/proadmin.php' => base_path('config/proadmin.php'),
        ], 'proadmin-config');

        $this->publishes([
            __DIR__.'/../storage/app/public/vendor/proadmin/icons' => storage_path('app/public/vendor/proadmin/icons'),
        ], 'proadmin-icons');

        $this->publishes([
            __DIR__.'/../storage/proadmin/collections.json' => storage_path('proadmin/collections.json'),
        ], 'proadmin-collections');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/proadmin'),
        ], 'proadmin-public');
	}

	public function register()
	{
	}
}
