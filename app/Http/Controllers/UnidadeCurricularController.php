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

    public function getUcsParaCurso($curso_id, $dep_id){
        /*
       $cursosADevolver = [];
        $cursosCasoDepartamentoTenhaCursos = 
            DB::table('curso')->where('departamento_id', $dep_id)->get();
        
        if(!$cursosCasoDepartamentoTenhaCursos->isEmpty()){
           foreach($cursosCasoDepartamentoTenhaCursos as $curso){
               array_push($cursosADevolver, $curso->nome_curso);
           }
            return $cursosADevolver;
        }
        else{
            $ucsDeDepartamento = DB::table('unidade_curricular')->where('departamento_id', $dep_id)->get();
            foreach($ucsDeDepartamento as $uc){
                $curso = DB::table('curso')->where('id', $uc->curso_id)->select('id', 'nome_curso')->get();
                //dd($curso[0]);
                array_push($cursosADevolver, $curso[0]);
                
            }
            //dd($cursosADevolver);
            //dd(array_unique($cursosADevolver, SORT_REGULAR));
            return array_unique($cursosADevolver, SORT_REGULAR);
            */
        $ucsADevolver = [];
        $cursosCasoDepartamentoTenhaCursos = 
        DB::table('curso')->where('departamento_id', $dep_id)->get();
        if(!$cursosCasoDepartamentoTenhaCursos->isEmpty()){
            $ucs = DB::table('unidade_curricular')
            ->where('curso_id', '=', $curso_id)
            ->select('nome')
            ->distinct('nome')
            ->get();
            return $ucs;
        }
        else{
            $ucsDeDepartamento = DB::table('unidade_curricular')
            ->where('departamento_id', $dep_id)
            ->select('nome')
            ->distinct('nome')
            ->get();
            return $ucsDeDepartamento;
        }
    }

    public function getRegimesParaUC($uc_name, $curso_id){
        $regimes = DB::table('unidade_curricular')
                    ->where('nome', '=', $uc_name)
                    ->where('curso_id', '=', $curso_id)
                    ->select('regime')
                    ->distinct('regime')
                    ->get();
        //dd($regimes);
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

    public function getTurnosParaUCNomeeRegime($uc_name, $uc_regime, $curso_id){
        $turnos = DB::table('unidade_curricular')
        ->where('nome', '=', $uc_name)
        ->where('regime', '=', $uc_regime)
        ->where('curso_id', '=', $curso_id)
        ->get();
        
        return $turnos;
    }

}
