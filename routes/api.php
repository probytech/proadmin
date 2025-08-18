<?php

use App\Proadmin\Controllers\ApiController;
use App\Proadmin\Controllers\SingleController;
use App\Proadmin\Facades\Collection;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Proadmin API Routes
|--------------------------------------------------------------------------
|
| Here is generated API routes for your proadmin application. These routes 
| were generated automatically using the data you entered in the admin panel.
| Enjoy building your API!
|
*/

if (config('proadmin.is_api_enabled')) {
    
    Route::group([
        'prefix' => 'api',
    ], function () {

        $collections = Collection::get();

        foreach ($collections as $collection) {

            Route::group([
                'prefix' => Lang::prefix(),
            ], function () use ($collection) {

                Route::get($collection->table_name, [ApiController::class, 'index'])
                    ->defaults('menu_item', $collection)
                    ->name('api-index-' . $collection->table_name);

                Route::get($collection->table_name . '/{id}', [ApiController::class, 'show'])
                    ->defaults('menu_item', $collection)
                    ->name('api-show-' . $collection->table_name);
            });

            Route::post($collection->table_name, [ApiController::class, 'store'])
                ->defaults('menu_item', $collection)
                ->name('api-store-' . $collection->table_name);

            Route::put($collection->table_name . '/{id}', [ApiController::class, 'update'])
                ->defaults('menu_item', $collection)
                ->name('api-update-' . $collection->table_name);

            Route::delete($collection->table_name . '/{id}', [ApiController::class, 'destroy'])
                ->defaults('menu_item', $collection)
                ->name('api-destroy-' . $collection->table_name);
        }

        Route::group([
            'prefix' => Lang::prefix(),
        ], function () {

            Route::get('/single/{slug}', [SingleController::class, 'first']);
        });
    });
}