<?php

namespace App\Proadmin\Facades;

use Illuminate\Support\Facades\Facade;

class Lang extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'lang';
	}
}