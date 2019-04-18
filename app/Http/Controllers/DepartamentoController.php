<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Resources\Departamento as DepartamentoResource;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    public function all(){
        $departamentos = DB::table('departamento')->get();
        return $departamentos;
    }
}
