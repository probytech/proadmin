<?php 

namespace App\Proadmin\Controllers;

use App\Proadmin\Exports\Export;
use App\Proadmin\Imports\Import;
use App\Proadmin\Responses\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends \App\Http\Controllers\Controller
{
    public function export ($table)
	{	
        return Excel::download(new Export($table), "export_".$table.date('YmdHis').".xlsx");
	}

    public function import (Request $r, $table)
    {
        $file = $r->file('xlsx');

        Excel::import(new Import($table), $file);

        return JsonResponse::response();
    }
}