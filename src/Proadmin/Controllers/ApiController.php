<?php 

namespace App\Proadmin\Controllers;

use App\Proadmin\Requests\Api\IndexRequest;
use App\Proadmin\Requests\Api\ShowRequest;
use App\Proadmin\Requests\Api\StoreRequest;
use App\Proadmin\Requests\Api\UpdateRequest;
use App\Proadmin\Services\ApiService;
use App\Proadmin\Services\FilterQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
		$data = $request->validated();

		$menuItem = $request->route()->parameter('menu_item');

		$service = new ApiService($menuItem);

		$filters = new FilterQueryBuilder($request);

		$items = $service->index($data, $filters);
		
		return Response::json($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
		$data = $request->validated();
        
		$menuItem = $request->route()->parameter('menu_item');

		$service = new ApiService($menuItem);

		$item = $service->store($data);

		return Response::json($item, 200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        $data = $request->validated();
		
		$menuItem = $request->route()->parameter('menu_item');

		$service = new ApiService($menuItem);

		$item = $service->show($id, $data);
		
		return Response::json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        
		$menuItem = $request->route()->parameter('menu_item');

		$service = new ApiService($menuItem);

		$item = $service->update($id, $data);

		return Response::json($item, 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $menuItem = $request->route()->parameter('menu_item');

		$service = new ApiService($menuItem);

		$service->destroy($id);

		return Response::json(['success' => true], 200);
    }
}