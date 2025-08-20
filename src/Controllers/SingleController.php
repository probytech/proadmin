<?php

namespace Probytech\Proadmin\Controllers;

use Probytech\Proadmin\Requests\SingleEditRequest;
use Probytech\Proadmin\Requests\SingleRemoveRequest;
use Probytech\Proadmin\Responses\JsonResponse;
use Probytech\Proadmin\Services\Single\SingleGetService;
use Probytech\Proadmin\Services\Single\SingleSetService;
use Probytech\Proadmin\Services\Single\SingleSaver;
use Probytech\Proadmin\Facades\Single;
use Illuminate\Http\Request;

class SingleController extends \App\Http\Controllers\Controller
{
	public function show(SingleGetService $service, $id)
	{
		$blocks = $service->get($id);

		return JsonResponse::response($blocks);
	}

	// TODO: validate parameters
	public function update(Request $request, SingleSetService $service)
	{
		$blocks = $request->get('blocks');

		$service->set($blocks);

		return JsonResponse::response();
	}

	public function destroy()
	{
	}

	public function first($slug)
	{
		return JsonResponse::response([
			'single'	=> Single::get($slug),
		]);
	}

	public function singleEdit(SingleEditRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->save($data['blocks']);

		return JsonResponse::response();
	}

	public function singleRemove(SingleRemoveRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->remove();

		return JsonResponse::response();
	}
}
