<?php

namespace App\Http\Controllers;

use App\PropostaProponente;
use App\PropostaProponenteAssistente;
use App\PropostaProponenteMonitor;
use App\PropostaProponenteProfessor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropostaProponenteController extends Controller
{
    public function getPropostasProponente()
    {
        return PropostaProponente::all();
    }

    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        $proposta = PropostaProponente::findOrFail($id);

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

        $proposta->update($request->all());
        $proposta->save();

        return response()->json($proposta, 200);
    }

    public function getPropostasPendentesCoordenadorDepartamento()
    {
        $propostasPendentesCoordenadorDepartamento =
        DB::table('proposta_proponente')
            ->whereNull('fundamentacao_coordenador_departamento')
            ->get();

        $propostasADevolver = [];
        array_push($propostasADevolver, $propostasPendentesCoordenadorDepartamento);
        return $propostasADevolver[0];
    }

    public function getHistoricoPropostasCoordenadorDepartamento()
    {
        $propostasPendentesCoordenadorDepartamento =
        DB::table('proposta_proponente')
            ->whereNotNull('fundamentacao_coordenador_departamento')
            ->get();

        //dd($propostasPendentesCoordenadorDepartamento);

        $propostasADevolver = [];
        array_push($propostasADevolver, $propostasPendentesCoordenadorDepartamento);
        return $propostasADevolver[0];
    }

    public function getPropostasPendentesCoordenadorCurso()
    {
        $propostasPendentesCoordenadorCurso =
        DB::table('proposta_proponente')
            ->whereNull('fundamentacao_coordenador_curso')
            ->get();

        $propostasADevolver = [];
        array_push($propostasADevolver, $propostasPendentesCoordenadorCurso);
        return $propostasADevolver[0];
    }

    public function getHistoricoPropostasCoordenadorCurso()
    {
        $propostasPendentesCoordenadorCurso =
        DB::table('proposta_proponente')
            ->whereNotNull('fundamentacao_coordenador_curso')
            ->get();

        $propostasADevolver = [];
        array_push($propostasADevolver, $propostasPendentesCoordenadorCurso);
        return $propostasADevolver[0];
    }

    public function inserirFundamentacaoCoordenadorDepartamento($propostaProponenteID, Request $request)
    {

        $propostaAAtualizar = PropostaProponente::findOrFail($propostaProponenteID);
        $propostaAAtualizar->fundamentacao_coordenador_departamento = $request->fundamentacao_coordenador_departamento;
        $propostaAAtualizar->data_de_assinatura_coordenador_departamento = $request->data_de_assinatura_coordenador_departamento;
        $propostaAAtualizar->segundo_proponente = $request->segundo_proponente;
        $propostaAAtualizar->save();
    }

    public function inserirFundamentacaoCoordenadorCurso($propostaProponenteID, Request $request)
    {
        $propostaAAtualizar = PropostaProponente::findOrFail($propostaProponenteID);
        $propostaAAtualizar->fundamentacao_coordenador_curso = $request->fundamentacao_coordenador_curso;
        $propostaAAtualizar->data_de_assinatura_coordenador_de_curso = $request->data_de_assinatura_coordenador_de_curso;
        $propostaAAtualizar->segundo_proponente = $request->segundo_proponente;
        $propostaAAtualizar->save();
    }

    public function apagarPropostasProponente($id, Request $request)
    {
        $role = $request->role;
        if($role == 'professor') {
            PropostaProponenteAssistente::where('proposta_proponente_id', $id)->delete();
            PropostaProponenteMonitor::where('proposta_proponente_id', $id)->delete();
        } else if($role == 'assistente') {
            PropostaProponenteProfessor::where('proposta_proponente_id', $id)->delete();
            PropostaProponenteMonitor::where('proposta_proponente_id', $id)->delete();
        } else if($role == 'monitor') {
            PropostaProponenteProfessor::where('proposta_proponente_id', $id)->delete();
            PropostaProponenteAssistente::where('proposta_proponente_id', $id)->delete();
        }

        return response()->json("PropostasProponente apagadas com sucesso!", 200);
    }

    //? FUNÇÕES ESTATISTICA

    public function getPropostasDoProponente($proponente_id)
    {
        $user = User::find($proponente_id);
        $arrayPropostas = DB::table('proposta_proponente')->where('primeiro_proponente', $user->name)->get();

        return $arrayPropostas;
    }

    public function getPropostasPorTipoDeDocente($proponente_id)
    {
        $user = User::find($proponente_id);
        
        $propostasProfessor = PropostaProponente::where('role', 'professor')->where('primeiro_proponente', $user->name)->count();
        $propostasAssistente = PropostaProponente::where('role', 'assistente')->where('primeiro_proponente', $user->name)->count();
        $propostasMonitor = PropostaProponente::where('role', 'monitor')->where('primeiro_proponente', $user->name)->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasProfessor);
        array_push($arrayADevolver, $propostasAssistente);
        array_push($arrayADevolver, $propostasMonitor);

        return $arrayADevolver;
    }

    public function getPropostasPorTipoDeContrato($proponente_id)
    {
        $user = User::find($proponente_id);

        $propostasContratacaoInicial = PropostaProponente::where('tipo_contrato', 'contratacao_inicial')->where('primeiro_proponente', $user->name)->count();
        $propostasRenovacao = PropostaProponente::where('tipo_contrato', 'renovacao')->where('primeiro_proponente', $user->name)->count();
        $propostasAlteracao = PropostaProponente::where('tipo_contrato', 'alteracao')->where('primeiro_proponente', $user->name)->count();

        $arrayADevolver = [];
        array_push($arrayADevolver, $propostasContratacaoInicial);
        array_push($arrayADevolver, $propostasRenovacao);
        array_push($arrayADevolver, $propostasAlteracao);

        return $arrayADevolver;
    }

    public function getPropostasNoUltimoMes($proponente_id)
    {
        $user = User::find($proponente_id);
        $arrayADevolver = array();
        $datasDaBD = array();
        $m = date("m");
        $de = date("d");
        $y = date("Y");
        $timestamps = DB::table('proposta_proponente')->where('primeiro_proponente', $user->name)->select('created_at')->get();
        foreach ($timestamps as $timestamp) {
            $t = explode(" ", $timestamp->created_at);
            array_push($datasDaBD, $t[0]);
        }

        for ($i = 0; $i <= 30; $i += 1) {
            $contador = 0;
            foreach ($datasDaBD as $data) {
                $d = str_replace("-", "/", $data);
                if (date("Y/m/d", mktime(0, 0, 0, $m, ($de - $i), $y)) == $d) {
                    $contador++;
                }
            }
            array_push($arrayADevolver, ['Data' => (string) date("Y/m/d", mktime(0, 0, 0, $m, ($de - $i), $y)), 'Quantidade' => $contador]);
        }
        return $arrayADevolver;
    }

    public function verificarSeJaExistemPropostasAtivasParaDocenteASerContratado($email){
        //dd($email);
        $propostasProponente = DB::table('proposta_proponente')->where('email', $email)->get();
        
        if(!$propostasProponente->isEmpty()){
            foreach($propostasProponente as $p){
                //dd($proposta->id_proposta_proponente);
                $proposta = DB::table('proposta')->join('proposta_proponente', 'proposta.proposta_proponente_id', 
                'proposta_proponente.id_proposta_proponente')->where('proposta.proposta_proponente_id', $p->id_proposta_proponente)->
                where('proposta.docente_inseriu_ficheiros', '=', 0)->get();
                var_dump($proposta);
                if(!$proposta->isEmpty()){
                    return response()->json(true);//Nao avanca
                }
            }
        }
        return response()->json(false); //Avanca
    }
}
