<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function dataWhitPaginate($model, $name)
	{
		return [
			'pagination' => [
                'total'         => $model->total(), // total de registros
                'current_page'  => $model->currentPage(), // pagina actual
                'per_page'      => $model->perPage(), // por pagina
                'last_page'     => $model->lastPage(), // ultima pagina
                'from'          => $model->firstItem(), // desde - primer elemento
                'to'            => $model->lastItem() // hasta - ultimo elemento
            ],
            $name => $model->all(),
            'permissionsUser'       => \Auth::user()->permissionsOfUser($this->module),
        ];
    }
}






