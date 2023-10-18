<?php 
namespace App\Proadmin\Controllers;

use App\Proadmin\Models\Menu;
use App\Proadmin\Requests\CreateTableRequest;
use App\Proadmin\Requests\RemoveTableRequest;
use App\Proadmin\Requests\UpdateTableRequest;
use App\Proadmin\Services\TableService;
use App\Proadmin\Responses\JsonResponse;
use App\Proadmin\Services\MigrationService;

class MigrationController extends \App\Http\Controllers\Controller
{
	private $tableService;
	private $migrationService;

	public function __construct(TableService $tableService, MigrationService $migrationService)
	{
		$this->tableService = $tableService;
		$this->migrationService = $migrationService;
	}

	public function createTable(CreateTableRequest $r)
	{
		$data = $r->validated();

		$tables = $this->tableService->getTables($data['table_name'], $data['multilanguage']);

		foreach ($tables as $table) {
			$this->migrationService->create($table, $data);
		}

		Menu::create($data);

		return JsonResponse::response();
	}

	public function removeTable(RemoveTableRequest $r)
	{
		$data = $r->validated();

		$tables = $this->tableService->getTables($data['id']);

		foreach ($tables as $table) {
			$this->migrationService->delete($table);
		}

		Menu::where('id', $data['id'])
		->delete();

		return JsonResponse::response();
	}

	public function updateTable(UpdateTableRequest $r)
	{
		$data = $r->validated();

		$tables = $this->tableService->getTables($data['table_name']);

		foreach ($tables as $table) {
			$this->migrationService->update($table, $data);
		}

		unset($data['id']);
		unset($data['to_remove']);
		
		Menu::where('table_name', $data['table_name'])
		->update($data);

		return JsonResponse::response();
	}
}