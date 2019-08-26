<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use App\Http\Resources\PropostaProponente as PropostaProponenteResource;
use Illuminate\Support\Facades\DB;

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
            'primeiro_proponente' => 'required',
            'area_cientifica' => 'required',
        ]);
        
        $propostaProponente = new PropostaProponente();
        $propostaProponente->fill($request->all());
        $propostaProponente->save();
        return $propostaProponente;
    }

    public function getPropostasPendentesCoordenadorDepartamento(){
        $propostasPendentesCoordenadorDepartamento = 
        DB::table('proposta_proponente')
        ->whereNull('fundamentacao_coordenador_departamento')
        ->get();

        $propostasADevolver=[];
        array_push($propostasADevolver, $propostasPendentesCoordenadorDepartamento);
        return $propostasADevolver[0];
    }

    public function getHistoricoPropostasCoordenadorDepartamento(){
        $propostasPendentesCoordenadorDepartamento = 
        DB::table('proposta_proponente')
        ->whereNotNull('fundamentacao_coordenador_departamento')
        ->get();

        //dd($propostasPendentesCoordenadorDepartamento);

        $propostasADevolver=[];
        array_push($propostasADevolver, $propostasPendentesCoordenadorDepartamento);
        return $propostasADevolver[0];
    }
    
    public function getPropostasPendentesCoordenadorCurso(){
        $propostasPendentesCoordenadorCurso = 
        DB::table('proposta_proponente')
        ->whereNull('fundamentacao_coordenador_curso')
        ->get();

        $propostasADevolver=[];
        array_push($propostasADevolver, $propostasPendentesCoordenadorCurso);
        return $propostasADevolver[0];
    }

    public function getHistoricoPropostasCoordenadorCurso(){
        $propostasPendentesCoordenadorCurso = 
        DB::table('proposta_proponente')
        ->whereNotNull('fundamentacao_coordenador_curso')
        ->get();

        $propostasADevolver=[];
        array_push($propostasADevolver, $propostasPendentesCoordenadorCurso);
        return $propostasADevolver[0];
    }
    
    public function inserirFundamentacaoCoordenadorDepartamento($propostaProponenteID, Request $request){

        $propostaAAtualizar = PropostaProponente::findOrFail($propostaProponenteID);
        $propostaAAtualizar->fundamentacao_coordenador_departamento = $request->fundamentacao_coordenador_departamento;
        $propostaAAtualizar->data_de_assinatura_coordenador_departamento = $request->data_de_assinatura_coordenador_departamento;
        $propostaAAtualizar->segundo_proponente = $request->segundo_proponente;
        $propostaAAtualizar->save();
    }

    public function inserirFundamentacaoCoordenadorCurso($propostaProponenteID, Request $request){
        $propostaAAtualizar = PropostaProponente::findOrFail($propostaProponenteID);
        $propostaAAtualizar->fundamentacao_coordenador_curso = $request->fundamentacao_coordenador_curso;
        $propostaAAtualizar->data_de_assinatura_coordenador_de_curso = $request->data_de_assinatura_coordenador_de_curso;
        $propostaAAtualizar->segundo_proponente = $request->segundo_proponente;
        $propostaAAtualizar->save();
    }
    
}
