<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use App\Http\Resources\PropostaProponente as PropostaProponenteResource;

class PropostaProponenteController extends Controller
{
    public function getPropostasProponente() {
        return PropostaProponente::all();
    }

    public function store(Request $request){
        $request->validate([
            'unidade_organica' => 'required',
            'nome_completo' => 'required',
            'email' => 'required',
            'numero_telefone' => 'required',
            'tipo_contrato' => 'required',
            'data_de_assinatura_coordenador_de_curso' => 'nullable',
            'data_de_assinatura_coordenador_departamento' => 'nullable',
            'fundamentacao_coordenador_curso' => 'nullable',
            'fundamentacao_coordenador_departamento' => 'nullable',
            'role' => 'required',
            'grau' => 'required',
            'curso' => 'required',
            'area_cientifica' => 'required',
        ]);
        
        $propostaProponente = new PropostaProponente();
        $propostaProponente->fill($request->all());
        $propostaProponente->save();
        return $propostaProponente;

    }
}
