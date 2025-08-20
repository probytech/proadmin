<?php

namespace Probytech\Proadmin\Controllers;

use Probytech\Proadmin\Facades\Collection;
use Probytech\Proadmin\Requests\CreateTableRequest;
use Probytech\Proadmin\Requests\RemoveTableRequest;
use Probytech\Proadmin\Requests\UpdateTableRequest;
use Probytech\Proadmin\Services\TableService;
use Probytech\Proadmin\Responses\JsonResponse;
use Probytech\Proadmin\Services\MigrationService;
use Probytech\Proadmin\Services\ModelService;

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

        Collection::create($data);

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

		Collection::delete($data['table_name']);

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

        Collection::update($data['table_name'], $data);

		return JsonResponse::response();
	}
}
