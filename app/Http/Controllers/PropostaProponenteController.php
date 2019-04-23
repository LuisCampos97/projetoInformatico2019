<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use App\Http\Resources\PropostaProponente as PropostaProponenteResource;

class PropostaProponenteController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'unidade_organica' => 'required',
            'nome_completo' => 'required',
            'data_de_assinatura_coordenador_departamento' => 'required',
            'tipo_contrato' => 'required'
        ]);
        $propostaProponente = new PropostaProponente();
        $propostaProponente->fill($request->all());
        $propostaProponente->save();
        return $propostaProponente;

    }
}
