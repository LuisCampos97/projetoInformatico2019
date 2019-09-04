<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponenteProfessor;

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
            'avaliacao_periodo_anterior' => 'nullable',
            'proposta_proponente_id' => 'required',
        ]);
        $propostaProponenteProfessor = new PropostaProponenteProfessor();
        $propostaProponenteProfessor->fill($request->all());
        $propostaProponenteProfessor->save();
        return response()->json($propostaProponenteProfessor, 200);

    }

    public function update(Request $request, $id)
    {
        $proposta = PropostaProponenteProfessor::findOrFail($id);

        $request->validate([
            'role_professor' => 'required',
            'regime_prestacao_servicos' => 'required',
            'percentagem_prestacao_servicos' => 'nullable|numeric|min:1',
            'fundamentacao' => 'nullable',
            'duracao' => 'required',
            'periodo' => 'required',
            'avaliacao_periodo_anterior' => 'nullable',
            'proposta_proponente_id' => 'required',
        ]);

        $proposta->fill($request->all());
        $proposta->save();

        return response()->json($proposta, 200);
    }

    public function getProposta($idPropostaProponente)
    {
        return PropostaProponenteProfessor::where('proposta_proponente_id', $idPropostaProponente)->first();
    }
}
