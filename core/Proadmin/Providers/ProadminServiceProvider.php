<?php

namespace App\Proadmin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use App\Proadmin\Commands\ProadminTranslate;
use App\Proadmin\Facades\Single as SingleFacade;
use App\Proadmin\Facades\Lang as LangFacade;
use App\Proadmin\Helpers\JSAssembler;
use App\Proadmin\Helpers\ResizeImg;
use App\Proadmin\Helpers\Field;
use App\Proadmin\Helpers\Platform;
use App\Proadmin\Helpers\Convertor;
use App\Proadmin\Helpers\SEO;
use App\Proadmin\Services\LanguageService;
use App\Proadmin\Single\Single as Single;
use View;

// TODO: divide this large provider
class ProadminServiceProvider extends ServiceProvider
{
	public $bindings = [
    ];
 
    public $singletons = [
        'lang' 		=> LanguageService::class,
		'single' 	=> Single::class,
    ];

	public function boot()
	{
		$this->app->bind('proadmin:translate', function ($app) {
			return new ProadminTranslate();
		});
		
		$this->commands([
			'proadmin:translate',
		]);

		Route::middleware('web')
			->group(base_path('routes/proadmin.php'));

		Blade::directive('desktopcss', function () {

			return "<?php ob_start(); ?>";
		});

		Blade::directive('mobilecss', function () {
		
			return '<?php Convertor::create($view_name, ob_get_clean(), true); ob_start(); ?>';
		});

		Blade::directive('endcss', function () {

			return '<?php Convertor::create($view_name, ob_get_clean(), false); ?>';
		});

		Blade::directive('startjs', function ($index) {
			
			return '<?php $position_js = '.($index ? $index : '1').'; ob_start(); ?>';
		});

		Blade::directive('endjs', function () {

			return '<?php JSAssembler::str($view_name.":".$position_js, ob_get_clean()); ?>';
		});
		
		View::composer('*', function($view){

			$view->with([
				'view_name' => $view->getName(),
			]);
		});

		Route::middleware('api')
		->prefix('api')
		->group(base_path('routes/proadmin_api.php'));
	}

	public function register()
	{
		$this->app->booting(function() {

			$loader = AliasLoader::getInstance();

			$loader->alias('Single', 		SingleFacade::class);
			$loader->alias('Lang', 			LangFacade::class);
			$loader->alias('JSAssembler', 	JSAssembler::class);
			$loader->alias('ResizeImg', 	ResizeImg::class);
			$loader->alias('Field', 		Field::class);
			$loader->alias('Platform', 		Platform::class);
			$loader->alias('Convertor', 	Convertor::class);
			$loader->alias('SEO', 			SEO::class);
		});
	}
}