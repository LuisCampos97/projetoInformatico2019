<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaDiretorUO;
use Illuminate\Support\Facades\DB;

class DiretorUOController extends Controller
{
    public function confirmarProposta($confirmacao, $parecer, $data){
        $confirmacaoDiretor = PopostaDiretorUO::create([
            'reconhecimento' => $confirmacao,
            'parecer' => $parecer,
            'data_assinatura' => $data
        ]);

        //$proposta = Proposta
    }

    public function getHistoricoPropostas(){
        $historico = DB::table('proposta')->whereNull('proposta_ctc_id')->where('proposta_diretor_uo_id', '!=', null)->get();
        return $historico;
    }

    public function getPropostasPendentes(){
        $propostasPendentes = DB::table('proposta')->whereNull('proposta_diretor_uo_id')->where('proposta_proponente_id', '!=', null)->get();
        return $propostasPendentes;
    }
}
