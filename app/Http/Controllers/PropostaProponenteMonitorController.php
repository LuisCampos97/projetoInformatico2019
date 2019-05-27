<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponenteMonitor;


class PropostaProponenteMonitorController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'regime_prestacao_servicos' => 'required',
            'percentagem_prestacao_servicos' => 'required|numeric|min:1',
            'duracao' => 'required',
            'periodo' => 'required',
            'proposta_proponente_id' => 'required',
        ]);
        $propostaProponenteMonitor = new PropostaProponenteMonitor();
        $propostaProponenteMonitor->fill($request->all());
        $propostaProponenteMonitor->save();
        return response()->json($propostaProponenteMonitor, 200);
    }

    public function getProposta($idPropostaProponente)
    {
        return PropostaProponenteMonitor::where('proposta_proponente_id', $idPropostaProponente)->first();
    }
}
