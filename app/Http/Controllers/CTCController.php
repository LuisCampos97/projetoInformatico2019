<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaCTC;
use Illuminate\Support\Facades\DB;

class CTCController extends Controller
{
    public function getPropostasPendentes() 
    {

    $propostasADevolver=[];
    $propostas = DB::table('proposta')
      ->join('proposta_proponente', 'proposta_proponente.id', 'proposta.proposta_proponente_id')
      ->join('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', '=', 'proposta_diretor_uo.id')
      ->whereNotNull('proposta.proposta_diretor_uo_id')
      ->whereNull('proposta.proposta_ctc_id')
      ->where('status', '=', 'pendente')
      ->get();

      array_push($propostasADevolver, $propostas);
      return $propostasADevolver[0];
    }

    public function store(Request $request){
        $request->validate([
            'votos_a_favor' => 'required',
            'votos_contra' => 'required',
            'votos_brancos' => 'required',
            'votos_nulos' => 'required',
            'aprovacao' => 'required',
            'data_assinatura' => 'required',
        ]);
        $propostaCTC = new PropostaCTC();
        $propostaCTC->fill($request->all());
        $propostaCTC->save();
        return response()->json($propostaCTC, 200);
    }

    public function getTipoPropostaRole($role, $proposta_proponente_id){
        $proposta_proponente_role = null;
        if($role == "professor"){
           $proposta_proponente_role = PropostaProponenteProfessor::findOrFail($proposta_proponente_id);
        }
        if($role == "assistente"){
           $proposta_proponente_role = PropostaProponenteAssistente::findOrFail($proposta_proponente_id);
        }
        if($role == "monitor"){
           $proposta_proponente_role = PropostaProponenteMonitor::findOrFail($proposta_proponente_id);
        }
  
        return $proposta_proponente_role;
     }

     public function getHistoricoPropostasCTC(){
      $propostasADevolver=[];

      $historicoPropostas=DB::table('proposta_proponente')
      ->leftJoin('proposta', 'proposta_proponente.id', 'proposta.proposta_proponente_id')
      ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id')
      ->leftJoin('proposta_ctc', 'proposta_ctc.id', 'proposta.proposta_ctc_id')
      ->whereNotNull('proposta.proposta_ctc_id')
      ->whereNull('proposta.proposta_secretariado_direcao_id')
      ->get();

      array_push($propostasADevolver, $historicoPropostas);
      
      return $propostasADevolver[0];
     }

}
