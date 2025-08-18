<?php 

namespace App\Proadmin\Controllers;

use App\Proadmin\Requests\SingleEditRequest;
use App\Proadmin\Requests\SingleRemoveRequest;
use App\Proadmin\Responses\JsonResponse;
use App\Proadmin\Services\Single\SingleGetService;
use App\Proadmin\Services\Single\SingleSetService;
use App\Proadmin\Single\SingleSaver;
use Illuminate\Http\Request;
use Single;

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