<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeCurricularController extends Controller
{
    public function all(){
        $ucs = DB::table('unidade_curricular')->get();
        return $ucs;
    }

    public function getUcParaId($id){
        $uc = DB::table('unidade_curricular')->where('id', '=', $id)->get();
        return $uc;
    }

    public function getUcsParaDepartamento($dep_id){
        $ucs = DB::table('unidade_curricular')
            ->where('departamento_id', '=', $dep_id)
            ->get();
        return $ucs;
    }
}
