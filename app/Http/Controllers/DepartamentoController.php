<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Resources\Departamento as DepartamentoResource;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    public function departamentoUserLogado($userDepName){
        //$userDepName = "Coordenador deo Departamento de Engenharia Informatica";
        //var_dump($userDepName);
        $test = str_replace(substr($userDepName, 0, 15), '', $userDepName);
        //dd($test);
        $departamento = DB::table('departamento')->where('nome_departamento','=' ,$test)->get();
        return $departamento;
    }
}
