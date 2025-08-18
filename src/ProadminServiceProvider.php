<?php

namespace Probytech\Proadmin;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ProadminServiceProvider extends ServiceProvider
{

	public function boot() 
	{
		Schema::defaultStringLength(191);

		if ($this->app->runningInConsole()) {
			$this->commands([
				\Probytech\Proadmin\Commands\ProadminInstall::class,
			]);
		}
	}

	public function register()
	{
	}
}