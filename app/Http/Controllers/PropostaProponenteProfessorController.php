<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponenteProfessor;
use App\Http\Resources\PropostaProponenteProfessor as PropostaProponenteProfessorResource;

class PropostaProponenteProfessorController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'role_professor' => 'required',
            'regime_prestacao_servicos' => 'required',
            'percentagem_prestacao_servicos' => 'nullable|numeric|min:1',
            'fundamentacao' => 'nullable',
            'duracao' => 'required',
            'periodo' => 'required',
            'proposta_proponente_id' => 'required',
        ]);
        $propostaProponenteProfessor = new PropostaProponenteProfessor();
        $propostaProponenteProfessor->fill($request->all());
        $propostaProponenteProfessor->save();
        return response()->json($propostaProponenteProfessor, 200);

    }
}
