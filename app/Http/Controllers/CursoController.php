<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function getUcsDisponiveisParaUserLogado($role)
    {
        $role = 'Coordenador de Engenharia Informática';

        $curso = str_replace(substr($role, 0, 15), '', $role);

        $codigo_curso = DB::table('curso')
            ->where('nome_curso', '=', $curso)
            ->select('codigo_curso')
            ->first()
            ->codigo_curso;

        $ucs = DB::table('unidade_curricular')->where('codigo_curso', '=', $codigo_curso)->get();
        dd($ucs);

        // $cursosADevolver = [];
        // $cursosCasoDepartamentoTenhaCursos = 
        //     DB::table('curso')->where('departamento_id', $dep_id)->get();

        // if(!$cursosCasoDepartamentoTenhaCursos->isEmpty()){
        //    foreach($cursosCasoDepartamentoTenhaCursos as $curso){
        //        array_push($cursosADevolver, $curso);
        //    }
        //    //dd($cursosADevolver);
        //     return $cursosADevolver;
        // }
        // else{
        //     $ucsDeDepartamento = DB::table('unidade_curricular')->where('departamento_id', $dep_id)->get();
        //     foreach($ucsDeDepartamento as $uc){
        //         $curso = DB::table('curso')->where('id', $uc->curso_id)->select('id', 'nome_curso')->get();
        //         //dd($curso[0]);
        //         array_push($cursosADevolver, $curso[0]);

        //     }
        //     //dd($cursosADevolver);
        //     //dd(array_unique($cursosADevolver, SORT_REGULAR));
        //     return array_unique($cursosADevolver, SORT_REGULAR);
        // }
    }
}
