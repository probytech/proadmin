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

		$this->publishes([
			__DIR__.'/../routes/api.php' => base_path('routes/proadmin_api.php'),
			__DIR__.'/../routes/web.php' => base_path('routes/proadmin.php'),
		]);

		Route::middleware('web')
		->group(base_path('routes/proadmin.php'));

		Route::middleware('api')
		->prefix('api')
		->group(base_path('routes/proadmin_api.php'));
	}

	public function register() {
		
	}
}