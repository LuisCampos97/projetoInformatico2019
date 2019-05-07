<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaCTC;

class CTCController extends Controller
{
    public function getPropostasPendentes() 
    {
    $propostas = DB::table('proposta')
      ->whereNotNull('proposta_proponente_id')
      ->whereNotNull('proposta_diretor_uo_id')
      ->whereNull('proposta_ctc_id')
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
            'votos_a_favor' => 'required',
            'votos_contra' => 'required',
            'votos_brancos' => 'required',
            'votos_nulos' => 'required',
            'aprovacao' => 'required'
        ]);
        $propostaCTC = new PropostaCTC();
        $propostaCTC->fill($request->all());
        $propostaCTC->save();
        return response()->json($propostaCTC, 200);

    }
}
