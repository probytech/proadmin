<?php

use Probytech\Proadmin\Controllers\AdminController;
use Probytech\Proadmin\Controllers\DocsController;
use Probytech\Proadmin\Controllers\ImportExportController;
use Probytech\Proadmin\Controllers\SingleController;
use Probytech\Proadmin\Controllers\LanguageController;
use Probytech\Proadmin\Controllers\MigrationController;
use Probytech\Proadmin\Facades\Lang;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
->prefix('admin')
->group(function () {

    Route::get('login', [AdminController::class, 'login'])->name('admin-login');
    Route::post('sign-in', [AdminController::class, 'signIn'])->name('admin-sign-in');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin-logout');

    Route::group([
        'middleware'    => [\Probytech\Proadmin\Middleware\AdminOnly::class],
    ], function() {

        Route::group(['prefix' => 'laravel-filemanager'], function() {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::get('/', [AdminController::class, 'admin'])->name('admin');

        Route::group([
            'prefix' => Lang::prefix(),
        ], function() {

            Route::get('api/single/{id}',	[SingleController::class, 'show'])->name('admin-single-show');
            Route::put('api/single/{id}',	[SingleController::class, 'update'])->name('admin-single-update');
            Route::delete('api/single/{id}',	[SingleController::class, 'destroy'])->name('admin-single-destroy');
        });

        Route::post('get-docs', [DocsController::class, 'index'])->name('admin-docs-index');

        Route::post('api/language/{tag}', 	[LanguageController::class, 'post'])->name('admin-language-create');
        Route::delete('api/language/{tag}',	[LanguageController::class, 'delete'])->name('admin-language-destroy');

        Route::post('update-dropdown', [AdminController::class, 'updateDropdown'])->name('admin-dropdown-update');
        Route::post('get-menu', [AdminController::class, 'getMenu'])->name('admin-menu-index');

        Route::post('get-dynamic', [AdminController::class, 'getDynamic'])->name('admin-dynamic-get');
        Route::post('set-dynamic', [AdminController::class, 'setDynamic'])->name('admin-dynamic-set');
        Route::post('save-editable', [AdminController::class, 'saveEditable'])->name('admin-editable-save');

        Route::post('db-copy', [AdminController::class, 'dbCopy'])->name('admin-db-copy');
        Route::post('db-count', [AdminController::class, 'dbCount'])->name('admin-db-count');
        Route::post('db-select', [AdminController::class, 'dbSelect'])->name('admin-db-select');
        Route::post('db-remove-row', [AdminController::class, 'dbRemoveRow'])->name('admin-db-remove-row');
        Route::post('db-remove-rows', [AdminController::class, 'dbRemoveRows'])->name('admin-db-remove-rows');

        Route::post('db-create-table', [MigrationController::class, 'createTable'])->name('admin-db-create-table');
        Route::post('db-remove-table', [MigrationController::class, 'removeTable'])->name('admin-db-remove-table');
        Route::post('db-update-table', [MigrationController::class, 'updateTable'])->name('admin-db-update-table');

        Route::post('single-edit', [SingleController::class, 'singleEdit'])->name('admin-single-edit');
        Route::post('single-remove', [SingleController::class, 'singleRemove'])->name('admin-single-remove');

        Route::post('upload-image', [AdminController::class, 'uploadImage'])->name('admin-upload-image');

        Route::get('export/{table}', [ImportExportController::class, 'export'])->name('admin-export');
        Route::post('import/{table}', [ImportExportController::class, 'import'])->name('admin-import');

        Route::get('{any}', [AdminController::class, 'admin'])->where('any', '.*');
    });
});
