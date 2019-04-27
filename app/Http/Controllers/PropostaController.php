<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposta;
use App\Http\Resources\Proposta as PropostaResource;
use Illuminate\Support\Facades\DB;


class PropostaController extends Controller
{
    public function inserirPropostaProponenteID($proposta_proponente_id){
        $proposta = DB::table('proposta')->insert([
            'proposta_proponente_id' => $proposta_proponente_id,
            'proposta_diretor_uo_id' => null,
            'proposta_ctc_id' => null,
            'proposta_secretariado_direcao_id' => null,
            'proposta_recursos_humanos_id' => null
        ]);

        return response()->json($proposta, 200);
    }
}
