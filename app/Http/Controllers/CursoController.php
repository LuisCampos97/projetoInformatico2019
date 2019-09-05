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

            $curso = Curso::where('codigo', $value_parsing[0])->get();

            if (!in_array($value_parsing[0], $array_codigo_cursos) && !empty($value_parsing[0] && $curso->isEmpty())) {
                $cursoAInserir = new Curso;
                $cursoAInserir->codigo = $value_parsing[0];
                $cursoAInserir->nome_curso = utf8_encode($value_parsing[1]);
                $cursoAInserir->save();

                //* Para não colocar o mesmo curso na Base de Dados
                array_push($array_codigo_cursos, $value_parsing[0]);
            }

            if(array_key_exists(2, $value_parsing)) {
                $uc = UnidadeCurricular::where('codigo', $value_parsing[2])->get();

                if (!in_array($value_parsing[2], $array_codigo_ucs) && !empty($value_parsing[2]) && $uc->isEmpty()) {
                    $ucAInserir = new UnidadeCurricular;
                    $ucAInserir->codigo = $value_parsing[2];
                    $ucAInserir->nome = utf8_encode($value_parsing[3]);
                    $ucAInserir->codigo_curso = $value_parsing[0];
                    $ucAInserir->save();
    
                    //* Para não colocar o mesmo UC na Base de Dados
                    array_push($array_codigo_ucs, $value_parsing[2]);
                }
            }
        }

        return response()->json("Cursos e Unidades Curriculares carregados com sucesso!", 200);;
    }

    public function criarCurso(Request $request){
        $curso = Curso::where('codigo', $request->codigo)->get();
        if(!$curso->isEmpty()){
            return response()->json("Já existe um curso com esse codigo", 401);
        }

        $nome = Curso::where('nome_curso', $request->nome_curso)->get();
        if(!$nome->isEmpty()){
            return response()->json("Já existe um curso com esse nome", 401);
        }
        $request->validate([
            'codigo' => 'required|numeric',
            'nome_curso' => 'required'
        ]);

        $cursoAInserir = new Curso();
        $cursoAInserir->fill($request->all());
        $cursoAInserir->save();
        return response()->json($cursoAInserir, 200);
    }
}
