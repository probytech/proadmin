<?php 

namespace App\Proadmin\Services;

use Illuminate\Http\Request;

class ProadminService
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function isAdminPanel()
	{
		return $this->request->is(config('proadmin.panel_url') . '/*') || $this->request->is(config('proadmin.panel_url'));
	}
}