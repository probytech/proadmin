<?php

namespace Probytech\Proadmin;

use App\Proadmin\Services\CollectionService;
use App\Proadmin\Services\LanguageService;
use App\Proadmin\Single\Single;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ProadminServiceProvider extends ServiceProvider
{
	public $singletons = [
        'lang' 		    => LanguageService::class,
		'single' 	    => Single::class,
		'collection' 	=> CollectionService::class,
    ];

	public function boot() {

		Schema::defaultStringLength(191);

		if ($this->app->runningInConsole()) {
			$this->commands([
				\Probytech\Proadmin\Commands\ProadminInstall::class,
			]);
		}

		$this->loadRoutesFrom(__DIR__.'/../routes/api.php');
		$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
	}

	public function register() {
		
	}
}