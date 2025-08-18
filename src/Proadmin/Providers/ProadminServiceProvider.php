<?php

namespace App\Proadmin\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Proadmin\Facades\Collection;
use App\Proadmin\Facades\Single as SingleFacade;
use App\Proadmin\Facades\Lang as LangFacade;
use App\Proadmin\Helpers\ResizeImg;
use App\Proadmin\Helpers\Field;
use App\Proadmin\Helpers\Platform;
use App\Proadmin\Helpers\SEO;
use App\Proadmin\Services\CollectionService;
use App\Proadmin\Services\LanguageService;
use App\Proadmin\Single\Single as Single;

// TODO: divide this large provider
class ProadminServiceProvider extends ServiceProvider
{
	public $bindings = [
    ];

    public $singletons = [
        'lang' 		    => LanguageService::class,
		'single' 	    => Single::class,
		'collection' 	=> CollectionService::class,
    ];

	public function boot()
	{
		Route::middleware('web')
		->group(base_path('routes/proadmin.php'));

		Route::middleware('api')
		->prefix('api')
		->group(base_path('routes/proadmin_api.php'));
	}

	public function register()
	{
		$this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$loader->alias('Collection', 	Collection::class);
			$loader->alias('Single', 		SingleFacade::class);
			$loader->alias('Lang', 			LangFacade::class);
			$loader->alias('SEO', 			SEO::class);
			$loader->alias('Field', 		Field::class);
			$loader->alias('Platform', 		Platform::class);
			$loader->alias('ResizeImg', 	ResizeImg::class);
		});
	}
}