<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UnidadeCurricular;

class UnidadeCurricularController extends Controller
{
    public function all()
    {
        $ucs = DB::table('unidade_curricular')->get();
        return $ucs;
    }

    public function getNomeUc($codigo_uc)
    {
        return UnidadeCurricular::where('codigo', $codigo_uc)->first()->nome;
    }

    public function getUcsParaCurso($codigo_curso)
    {
        $ucs = DB::table('unidade_curricular')
            ->where('codigo_curso', '=', $codigo_curso)
            ->get();

        return $ucs;
    }

    public function getTipoUC($codigo_uc)
    {
        $tipo = DB::table('unidade_curricular')
            ->where('codigo', '=', $codigo_uc)
            ->select('tipo')
            ->distinct('tipo')
            ->get();

        return $tipo;
    }

    public function getNomesUC($codigoUC){
        //dd($codigoUC);
        $nome = UnidadeCurricular::where('codigo', $codigoUC)->first()->nome;
        return $nome;
    }

    public function criarUC(Request $request){
        $uc = UnidadeCurricular::where('codigo', $request->codigo)->get();
        if(!$uc->isEmpty()){
            return response()->json("Já existe uma UC com esse codigo", 401);
        }

        $nome = UnidadeCurricular::where('nome', $request->nome)->get();
        if(!$nome->isEmpty()){
            return response()->json("Já existe uma UC com esse nome", 401);
        }
        $request->validate([
            'codigo' => 'required|numeric',
            'nome' => 'required',
            'codigo_curso' => 'required',
        ]);
        $ucAInserir = new UnidadeCurricular();
        $ucAInserir->fill($request->all());
        $ucAInserir->save();
        return response()->json($ucAInserir, 200);
    }
}
