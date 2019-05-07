<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaDiretorUO;
use Illuminate\Support\Facades\DB;

class DiretorUOController extends Controller
{
   public function getPropostasPendentes() 
   {
      $propostas = DB::table('proposta')
      ->whereNotNull('proposta_proponente_id')
      ->whereNull('proposta_diretor_uo_id')
      ->get();

      //dd($propostas);
      $propostasADevolver=[];

      foreach($propostas as $proposta) {
         //var_dump($proposta->proposta_proponente_id);
         $propostaProponente=DB::table('proposta_proponente')->where('id', '=', $proposta->proposta_proponente_id)->get();
         array_push($propostasADevolver, $propostaProponente);
         //dd($propostaProponente);
      }
      return $propostasADevolver;
   }

   public function store(Request $request){
      $request->validate([
         'reconhecimento' => 'required',
         'parecer' => 'required',
         'data_assinatura' => 'required'
      ]);
      $propostaDiretorUO = new PropostaDiretorUO();
      $propostaDiretorUO->fill($request->all());
      $propostaDiretorUO->save();
      return response()->json($propostaDiretorUO, 200);

   }
    
}
