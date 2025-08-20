<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Admin Panel Path
	|--------------------------------------------------------------------------
	|
	| This option define url for the admin panel
	|
	*/

	'panel_url' => 'admin',

	/*
	|--------------------------------------------------------------------------
	| Single save query parameter
	|--------------------------------------------------------------------------
	|
	| This option define query parameter for the single saving
	|
	*/

	'single_save_query' => 'update',

	'is_dev' => env('PROADMIN_DEV', true),

	'is_api_enabled' => env('PROADMIN_API_ENABLED', false),
];
