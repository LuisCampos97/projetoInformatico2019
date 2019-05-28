<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Curso;
use App\UnidadeCurricular;

class CursoController extends Controller
{
    public function getCursos()
    {
        //$nome_curso = str_replace(substr($role, 0, 15), '', $role);
        //$curso = Curso::where('nome_curso', $nome_curso)->first();

        return Curso::all();
    }

    public function lerCursosEUcs()
    {
        $page = file_get_contents('http://www.dei.estg.ipleiria.pt/intranet/horarios/ws/inscricoes/cursos_ucs.php?anoletivo=201819&periodo=S1')
            . file_get_contents('http://www.dei.estg.ipleiria.pt/intranet/horarios/ws/inscricoes/cursos_ucs.php?anoletivo=201819&periodo=S2');;


        $uc = explode("<br>", $page);
        $array_codigo_cursos = array();
        $array_codigo_ucs = array();

        foreach ($uc as $value) {
            $value_parsing = explode(";", $value);

            if (!in_array($value_parsing[0], $array_codigo_cursos) && !empty($value_parsing[0])) {
                $curso = new Curso;
                $curso->codigo = $value_parsing[0];
                $curso->nome_curso = utf8_encode($value_parsing[1]);
                $curso->save();

                //* Para não colocar o mesmo curso na Base de Dados
                array_push($array_codigo_cursos, $value_parsing[0]);
            }

            if (!in_array($value_parsing[2], $array_codigo_ucs) && !empty($value_parsing[2])) {
                $uc = new UnidadeCurricular;
                $uc->codigo = $value_parsing[2];
                $uc->nome = utf8_encode($value_parsing[3]);
                $uc->codigo_curso = $value_parsing[0];
                $uc->save();

                //* Para não colocar o mesmo UC na Base de Dados
                array_push($array_codigo_ucs, $value_parsing[2]);
            }
        }

        return 'Sucesso';
    }
}
