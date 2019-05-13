<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponenteAssistente;
use App\Http\Resources\PropostaProponenteAssistente as PropostaProponenteAssistenteResource;

class PropostaProponenteAssistenteController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'regime_prestacao_servicos' => 'required',
            'percentagem_prestacao_servicos' => 'nullable|numeric|min:1',
            'fundamentacao' => 'required',
            'duracao' => 'required',
            'data_inicio_contrato' => 'required',
            'data_fim_contrato' => 'required',
            'proposta_proponente_id' => 'required',
        ]);
        $propostaProponenteAssistente = new PropostaProponenteAssistente();
        $propostaProponenteAssistente->fill($request->all());
        $propostaProponenteAssistente->save();
        return response()->json($propostaProponenteAssistente, 200);
    }
}
