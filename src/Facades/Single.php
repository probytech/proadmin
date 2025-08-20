<?php

namespace Probytech\Proadmin\Facades;

use Illuminate\Support\Facades\Facade;

class Single extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'single';
	}
}
