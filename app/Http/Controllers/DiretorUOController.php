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

      foreach($propostas as $proposta) {
         //var_dump($proposta->proposta_proponente_id);
         $propostaProponente=DB::table('proposta_proponente')->where('id', '=', $proposta->proposta_proponente_id)->get();
         dd($propostaProponente);
      }
   }
    
}
