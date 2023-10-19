<?php 

namespace App\Proadmin\Controllers;

use App\Proadmin\Models\Menu;
use App\Proadmin\Requests\CreateTableRequest;
use App\Proadmin\Requests\RemoveTableRequest;
use App\Proadmin\Requests\UpdateTableRequest;
use App\Proadmin\Services\TableService;
use App\Proadmin\Responses\JsonResponse;
use App\Proadmin\Services\MigrationService;
use App\Proadmin\Services\ModelService;

class MigrationController extends \App\Http\Controllers\Controller
{
	private $tableService;
	private $migrationService;
	private $modelService;

	public function __construct(TableService $tableService, MigrationService $migrationService, ModelService $modelService)
	{
		$this->tableService = $tableService;
		$this->migrationService = $migrationService;
		$this->modelService = $modelService;
	}

	public function createTable(CreateTableRequest $r)
	{
		$data = $r->validated();

		$data['model'] = $this->modelService->create($data);

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

		$tables = $this->tableService->getTables($data['table_name']);

		$this->modelService->delete($data);

		foreach ($tables as $table) {
			$this->migrationService->delete($table);
		}

		Menu::where('table_name', $data['table_name'])
		->delete();

		return JsonResponse::response();
	}

	public function updateTable(UpdateTableRequest $r)
	{
		$data = $r->validated();

		$this->modelService->update($data);

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