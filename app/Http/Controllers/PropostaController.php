<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposta;
use App\Http\Resources\Proposta as PropostaResource;
use Illuminate\Support\Facades\DB;


class PropostaController extends Controller
{
    public function inserirPropostaProponenteID($proposta_proponente_id){
        DB::table('proposta')->insert([
            'proposta_proponente_id' => $proposta_proponente_id,
            'proposta_diretor_uo_id' => null,
            'proposta_ctc_id' => null,
            'proposta_secretariado_direcao_id' => null,
            'proposta_recursos_humanos_id' => null
        ]);
        
        $proposta=DB::table('proposta')->where('proposta_proponente_id', $proposta_proponente_id)->get();
        return $proposta[0]->id;
    }

    public function atualizarPropostaDiretor($idPropostaDiretorUO, $propostaID, $reconhecimento){
        $proposta = Proposta::findOrFail($propostaID);
        if($reconhecimento == 'Desfavoravel'){
            $proposta->status = 'recusada';
        }
        $proposta->proposta_diretor_uo_id = $idPropostaDiretorUO;
        $proposta->save();
        return response()->json($proposta, 201);
    }

    public function atualizarPropostaCTC($idPropostaCTC, $propostaID, $aprovacao){
        $proposta = Proposta::findOrFail($propostaID);
        if($aprovacao == 'naoaprovado'){
            $proposta->status = 'recusada';
        }
        $proposta->proposta_ctc_id = $idPropostaCTC;
        $proposta->save();
        return response()->json($proposta, 201);
    }

    public function atualizarPropostaSecretariadoDirecao($idPropostaSecretariadoDirecao, $propostaID){
        $proposta = Proposta::findOrFail($propostaID);
        $proposta->proposta_secretariado_direcao_id = $idPropostaSecretariadoDirecao;
        $proposta->save();
    }

    public function atualizarPropostaRecursosHumanos($propostaRecursoHumanosID, $propostaID){
        $proposta = Proposta::findOrFail($propostaID);
        $proposta->proposta_recursos_humanos_id = $propostaRecursoHumanosID;
        $proposta->status = 'finalizada';
        $proposta->save();
    }

    public function all() {
        return Proposta::all();
    }
}
