<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaDiretorUO;
use Illuminate\Support\Facades\DB;
use App\PropostaProponenteProfessor;
use App\PropostaProponenteAssistente;
use App\PropostaProponenteMonitor;

class DiretorUOController extends Controller
{
   public function getPropostasPendentes() 
   {
      $propostasADevolver=[];

      $propostaProponente=DB::table('proposta_proponente')
      ->join('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
      ->whereNotNull('proposta.proposta_proponente_id')
      ->whereNull('proposta.proposta_diretor_uo_id')
      ->whereNotNull('proposta_proponente.fundamentacao_coordenador_departamento')
      ->whereNotNull('proposta_proponente.fundamentacao_coordenador_curso')
      ->get();

      array_push($propostasADevolver, $propostaProponente);
      
      return $propostasADevolver[0];
   }

   public function store(Request $request){
      if($request->reconhecimento == true){
         $request->reconhecimento = 1;
      }
      else{
         $request->reconhecimento = 0;
      }
      $request->validate([
         'reconhecimento' => 'required',
         'parecer' => 'required',
         'data_assinatura' => 'required'
      ]);
      
      //dd($request->reconhecimento);
      $propostaDiretorUO = new PropostaDiretorUO();
      $propostaDiretorUO->fill($request->all());
      $propostaDiretorUO->save();
      return response()->json($propostaDiretorUO, 200);
   }

   public function getTipoPropostaRole($role, $proposta_proponente_id){
      
      $proposta_proponente_role = null;
      if($role == "professor"){
         $proposta_proponente_role = DB::table('proposta_proponente_professor')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }
      if($role == "assistente"){
         $proposta_proponente_role = DB::table('proposta_proponente_assistente')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }
      if($role == "monitor"){
         $proposta_proponente_role = DB::table('proposta_proponente_monitor')
         ->where('proposta_proponente_id', $proposta_proponente_id)->get();
      }

      return $proposta_proponente_role;
   }

   public function getUCSPropostaSelecionada($proposta_proponente_id){
      $ucs = DB::table('ucs_proposta_proponente')->where('proposta_proponente_id', $proposta_proponente_id)->get();
      return $ucs;
   }

   public function getHistoricoPropostas(){
      $propostasADevolver=[];

      $historicoPropostas=DB::table('proposta_proponente')
      ->leftJoin('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
      ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
      ->whereNotNull('proposta.proposta_diretor_uo_id')
      ->get();

      array_push($propostasADevolver, $historicoPropostas);
      
      return $propostasADevolver[0];
   }
    
}
