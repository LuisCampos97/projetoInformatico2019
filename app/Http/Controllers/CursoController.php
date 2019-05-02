<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function getUcsDisponiveisParaUserLogado($dep_id){
        $cursosADevolver = [];
        $cursosCasoDepartamentoTenhaCursos = 
            DB::table('curso')->where('departamento_id', $dep_id)->get();
        
        if(!$cursosCasoDepartamentoTenhaCursos->isEmpty()){
           foreach($cursosCasoDepartamentoTenhaCursos as $curso){
               array_push($cursosADevolver, $curso);
           }
           //dd($cursosADevolver);
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
        }
    }
}
