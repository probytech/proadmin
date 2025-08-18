<?php

namespace Probytech\Proadmin;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
	}

	public function register() {
		
	}
}