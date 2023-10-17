<?php

namespace Probytech\Proadmin;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ProadminServiceProvider extends ServiceProvider
{

	public function boot() {

		Schema::defaultStringLength(191);

		$this->app->bind('proadmin:install', function ($app) {
			return new \Probytech\Proadmin\Commands\ProadminInstall();
		});
		$this->commands([
			'proadmin:install',
		]);

		// $this->publishes([
		// 	__DIR__.'/../public' => public_path('vendor/proadmin'),
		// ], 'proadmin_public');

		// $this->publishes([
		// 	__DIR__.'/views'  => base_path('resources/views/proadmin'),
		// ], 'proadmin_view');
	}

	public function register() {
		
	}
}