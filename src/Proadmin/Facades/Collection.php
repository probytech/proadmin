<?php

namespace App\Proadmin\Facades;

use Illuminate\Support\Facades\Facade;

class Collection extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'collection';
	}
}
