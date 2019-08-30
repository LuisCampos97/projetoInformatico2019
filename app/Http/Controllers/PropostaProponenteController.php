<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use App\Http\Resources\PropostaProponente as PropostaProponenteResource;
use Illuminate\Support\Facades\DB;
use App\PropostaProponenteProfessor;
use App\PropostaProponenteAssistente;
use App\PropostaProponenteMonitor;

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
    
    public function getProponentesQueIniciamPropostas(){
        $arrayADevolver = array();
        $utilizadores = DB::table('proposta_proponente')->select('primeiro_proponente')->distinct()->get();
        foreach($utilizadores as $utilizador){
            $numeroDePropostas = DB::table('proposta_proponente')->where('primeiro_proponente', $utilizador->primeiro_proponente)->count();
            array_push($arrayADevolver, ['Utilizador' => $utilizador->primeiro_proponente, 'Número de Propostas' => $numeroDePropostas]);
        }

        return $arrayADevolver;
    }

    public function getPropostaPorTipoDeDocente(){
        $propostasProfessor = PropostaProponenteProfessor::all()->count();
        $propostasAssistente = PropostaProponenteAssistente::all()->count();
        $propostasMonitor = PropostaProponenteMonitor::all()->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasProfessor);
        array_push($arrayADevolver, $propostasAssistente);
        array_push($arrayADevolver, $propostasMonitor);

        return $arrayADevolver;

    }

    public function getPropostasUltimoMes(){
        
        $arrayADevolver = array();
        $datasDaBD = array();
        $m= date("m");
        $de= date("d");
        $y= date("Y");
        
        $timestamps  = DB::table('proposta_proponente')->select('created_at')->get();
        foreach($timestamps as $timestamp){
            $t = explode(" ", $timestamp->created_at);
            array_push($datasDaBD, $t[0]);
        }
        //dd($datasDaBD);
        
        for($i=0; $i<=30; $i++){ 
            $contador = 0;
            foreach($datasDaBD as $data){
                $d = str_replace("-", "/", $data);
                if(date("Y/m/d", mktime(0,0,0,$m,($de-$i),$y)) == $d){
                    $contador++;
                }
              }
              
              array_push($arrayADevolver, ['Dia' =>date("Y/m/d", mktime(0,0,0,$m,($de-$i),$y)), 'Quantidade' => $contador]);
            }
        return $arrayADevolver;
    }
    
    public function getTipoDeContrato(){
        $propostasContratacaoInicial = PropostaProponente::where('tipo_contrato', 'contratacao_inicial')->count();
        $propostasRenovacao = PropostaProponente::where('tipo_contrato', 'renovacao')->count();
        $propostasAlteracao = PropostaProponente::where('tipo_contrato', 'alteracao')->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasContratacaoInicial);
        array_push($arrayADevolver, $propostasRenovacao);
        array_push($arrayADevolver, $propostasAlteracao);

        return $arrayADevolver;
    }

    public function verificarSeJaExistemPropostasAtivasParaDocenteASerContratado($email){
        //dd($email);
        $propostasProponente = DB::table('proposta_proponente')->where('email', $email)->get();
        //dd($propostaProponente);
        if(!$propostasProponente->isEmpty()){
            foreach($propostasProponente as $proposta){
                //dd($proposta->id_proposta_proponente);
                $proposta = DB::table('proposta')->join('proposta_proponente', 'proposta.proposta_proponente_id', 
                'proposta_proponente.id_proposta_proponente')->where('proposta.proposta_proponente_id', $proposta->id_proposta_proponente)->
                where('proposta.docente_inseriu_ficheiros', '==', 0)->get();
                if($proposta->isEmpty()){
                    return response()->json(false);
                }
                else{
                    return response()->json(true);
                }
            }
           
        }
        return response()->json(false);
    }
}
