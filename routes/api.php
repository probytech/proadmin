<?php

use Probytech\Proadmin\Controllers\ApiController;
use Probytech\Proadmin\Controllers\SingleController;
use Probytech\Proadmin\Facades\Collection;
use Illuminate\Support\Facades\Route;
use Probytech\Proadmin\Facades\Lang;

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

    Route::middleware('api')
    ->prefix('api')
    ->group(function () {

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
