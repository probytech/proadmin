<?php

use App\Proadmin\Controllers\AdminController;
use App\Proadmin\Controllers\ApiController;
use App\Proadmin\Controllers\ImportExportController;
use App\Proadmin\Controllers\SingleController;
use App\Proadmin\Controllers\LanguageController;
use App\Proadmin\Controllers\MigrationController;

Route::post('/sign-in', [AdminController::class, 'signIn']);
Route::post('/admin/logout', [AdminController::class, 'logout']);
Route::get('/login', [AdminController::class, 'login']);

Route::group([
	'middleware'    => [\App\Proadmin\Middleware\AdminOnly::class],
], function() {

	Route::group(['prefix' => 'laravel-filemanager'], function() {
		\UniSharp\LaravelFilemanager\Lfm::routes();
	});

	Route::get('/admin', [AdminController::class, 'admin']);

	Route::group([
		'prefix' => Lang::prefix(),
	], function() {

		Route::get('/admin/api/single/{id}',	[SingleController::class, 'show']);
		Route::put('/admin/api/single/{id}',	[SingleController::class, 'update']);
		Route::delete('/admin/api/single/{id}',	[SingleController::class, 'destroy']);
	});

	Route::post('/admin/api/language/{tag}', 	[LanguageController::class, 'post']);
	Route::delete('/admin/api/language/{tag}',	[LanguageController::class, 'delete']);

	Route::post('/admin/update-dropdown', [ApiController::class, 'updateDropdown']);
	Route::post('/admin/get-menu', [ApiController::class, 'getMenu']);

	Route::post('/admin/get-dynamic', [ApiController::class, 'getDynamic']);
	Route::post('/admin/set-dynamic', [ApiController::class, 'setDynamic']);
	Route::post('/admin/save-editable', [ApiController::class, 'saveEditable']);

	Route::post('/admin/db-copy', [ApiController::class, 'dbCopy']);
	Route::post('/admin/db-count', [ApiController::class, 'dbCount']);
	Route::post('/admin/db-select', [ApiController::class, 'dbSelect']);
	Route::post('/admin/db-remove-row', [ApiController::class, 'dbRemoveRow']);
	Route::post('/admin/db-remove-rows', [ApiController::class, 'dbRemoveRows']);

	Route::post('/admin/db-create-table', [MigrationController::class, 'createTable']);
	Route::post('/admin/db-remove-table', [MigrationController::class, 'removeTable']);
	Route::post('/admin/db-update-table', [MigrationController::class, 'updateTable']);

	Route::post('/admin/single-edit', [SingleController::class, 'singleEdit']);
	Route::post('/admin/single-remove', [SingleController::class, 'singleRemove']);

	Route::post('/admin/upload-image', [ApiController::class, 'uploadImage']);

	Route::post('/admin/get-mainpage', [ApiController::class, 'getMainpage']);

	Route::get('/admin/export/{table}', [ImportExportController::class, 'export'])->name('admin-export');
	Route::post('/admin/import/{table}', [ImportExportController::class, 'import'])->name('admin-import');	
	
	Route::get('/admin/{any}', [AdminController::class, 'admin'])->where('any', '.*');
});