<?php 

namespace App\Proadmin\Controllers;

use App\Proadmin\Requests\SingleEditRequest;
use App\Proadmin\Requests\SingleRemoveRequest;
use App\Proadmin\Services\Single\SingleGetService;
use App\Proadmin\Services\Single\SingleSetService;
use App\Proadmin\Single\SingleSaver;
use Illuminate\Http\Request;

class SingleController extends \App\Http\Controllers\Controller
{
	public function show(SingleGetService $service, $id)
	{
		$blocks = $service->get($id);

		return $this->response($blocks);
	}
	
	// TODO: validate parameters
	public function update(Request $request, SingleSetService $service)
	{
		$blocks = $request->get('blocks');

		$service->set($blocks);

		return $this->response();
	}

	public function singleEdit(SingleEditRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->save($data['blocks']);

		return $this->response();
	}

	public function singleRemove(SingleRemoveRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->remove();

		return $this->response();
	}
}