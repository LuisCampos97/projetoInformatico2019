<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficheiro;

class FicheiroController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'proposta_id' => 'required'
        ]);
        $ficheiro = new Ficheiro();
        $ficheiro->fill($request->all());
        $ficheiro->save();
        return response()->json($ficheiro, 200);

    }
}
