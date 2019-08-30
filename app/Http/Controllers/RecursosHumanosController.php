<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaRecursosHumanos;
use Illuminate\Support\Facades\DB;

class RecursosHumanosController extends Controller
{
    public function getPropostasPendentes(){
        $propostasADevolver=[];
        $propostas = DB::table('proposta')
          ->join('proposta_proponente', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
          ->join('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', '=', 'proposta_diretor_uo.id_proposta_diretor_uo')
          ->join('proposta_ctc', 'proposta.proposta_ctc_id', 'proposta_ctc.id_proposta_ctc')
          ->join('proposta_secretariado_direcao', 'proposta.proposta_secretariado_direcao_id', 'proposta_secretariado_direcao.id_proposta_secretariado_direcao')
          ->where('proposta.docente_inseriu_ficheiros', '=', true)
          ->whereNull('proposta.proposta_recursos_humanos_id')
          ->where('status', '!=', 'rejeitado')
          ->get();

          array_push($propostasADevolver, $propostas);
  
          return $propostasADevolver[0];
    }

    public function getHistoricoPropostas(){
        $propostasADevolver=[];
  
        $historicoPropostas=DB::table('proposta_proponente')
        ->leftJoin('proposta', 'proposta_proponente.id_proposta_proponente', 'proposta.proposta_proponente_id')
        ->leftJoin('proposta_diretor_uo', 'proposta.proposta_diretor_uo_id', 'proposta_diretor_uo.id_proposta_diretor_uo')
        ->leftJoin('proposta_ctc', 'proposta_ctc.id_proposta_ctc', 'proposta.proposta_ctc_id')
        ->leftJoin('proposta_secretariado_direcao', 'proposta.proposta_secretariado_direcao_id', 'proposta_secretariado_direcao.id_proposta_secretariado_direcao')
        ->leftJoin('proposta_recursos_humanos', 'proposta.proposta_recursos_humanos_id', 'proposta_recursos_humanos.id_proposta_recursos_humanos')
        ->whereNotNull('proposta.proposta_recursos_humanos_id')
        ->get();
  
        array_push($propostasADevolver, $historicoPropostas);
        return $propostasADevolver[0];
    }

    public function store(Request $request){
      $request->validate([
        'remuneracao' => 'required',
        'escalao' => 'required',
        'indice' => 'required',
        'verificacao_outras_uo' => 'required',
        'nome_uo' => 'nullable',
        'tempo_parcial_uo' => 'nullable',
        'periodo_uo' => 'nullable',
        'numero_funcionario' => 'required',
        'contratacao_comunicada' => 'required',
        'inscricao' => 'required',
        'despacho_presidente_ipl' => 'required',
        'contrato_redigido' => 'required',
        'contrato_anexo' => 'required',
        'cessacao_social' => 'required',
        'NISS_ou_numero_CGA' => 'required',
        'data_nascimento' => 'required',
        'numero_CC' => 'required',
        'email_recursos_humanos' => 'required',
        'dados_GIAF_carregados_por' => 'required',
        'data_carregamento_dados_GIAF' => 'required',
        'recursos_humanos_id' => 'required'
      ]);
      $propostaRecursosHumanos = new PropostaRecursosHumanos();
      $propostaRecursosHumanos->fill($request->all());
      $propostaRecursosHumanos->save();
      return response()->json($propostaRecursosHumanos, 200);
    }

    //? FUNÇÕES ESTATISTICA
    public function getPropostas($recursos_humanos_id)
    {
        $arrayPropostas = DB::table('proposta_recursos_humanos')->where('recursos_humanos_id', $recursos_humanos_id)->get();

        return $arrayPropostas;
    }
}
