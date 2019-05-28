<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficheiro;

class FicheiroController extends Controller
{
    public function store(Request $request)
    {
        //$file =

        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'proposta_id' => 'required'
        ]);
        $ficheiro = new Ficheiro();
        $ficheiro->nome = $request->proposta_id . '_' . $request->nome;
        $ficheiro->descricao = $request->descricao;
        $ficheiro->proposta_id = $request->proposta_id;
        $ficheiro->save();

        //Storage::disk('local')->putFileAs('ficheiros/' . $request->proposta_id, $file, $ficheiro->nome);
        return response()->json($ficheiro, 200);
    }

    public function getFicheiros($proposta_id)
    {
        return Ficheiro::where('proposta_id', $proposta_id)->get();
    }
}
