<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponenteMonitor;
use App\Http\Resources\PropostaProponenteMonitor as PropostaProponenteMonitorResource;


class PropostaProponenteMonitorController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'regime_prestacao_servicos' => 'required',
            'percentagem_prestacao_servicos' => 'required|numeric|min:1',
            'duracao' => 'required',
            'data_inicio_contrato' => 'required',
            'data_fim_contrato' => 'required',
            'proposta_proponente_id' => 'required',
        ]);
        $propostaProponenteMonitor = new PropostaProponenteMonitor();
        $propostaProponenteMonitor->fill($request->all());
        $propostaProponenteMonitor->save();
        return response()->json($propostaProponenteMonitor, 200);
    }
}
