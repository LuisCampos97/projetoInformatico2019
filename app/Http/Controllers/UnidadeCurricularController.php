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
            ->select('nome')
            ->distinct('nome')
            ->get();

        return $ucs;
    }

    public function getRegimesParaUC($uc_name){
        $regimes = DB::table('unidade_curricular')
                    ->where('nome', '=', $uc_name)
                    ->select('regime')
                    ->distinct('regime')
                    ->get();

        return $regimes;
    }

    public function getTipoUC($uc_name){
        $tipo = DB::table('unidade_curricular')
                ->where('nome', '=', $uc_name)
                ->select('tipo')
                ->distinct('tipo')
                ->get();

        return $tipo;
    }

    public function getTurnosParaUCNomeeRegime($uc_name, $uc_regime){
        $turnos = DB::table('unidade_curricular')
        ->where('nome', '=', $uc_name)
        ->where('regime', '=', $uc_regime)
        ->get();
        
        return $turnos;
    }

}
