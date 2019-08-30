<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;
use Illuminate\Support\Facades\DB;

class NovoDocenteController extends Controller
{
    public function getProposta($emailDocente){
        $propostaProponente =DB::table('proposta_proponente')->where('email', $emailDocente)->get();
        //dd($propostaProponente);
        $proposta = DB::table('proposta')->join('proposta_proponente', 'proposta.proposta_proponente_id', 'proposta_proponente.id_proposta_proponente')->
                    where('proposta.proposta_proponente_id', $propostaProponente[0]->id_proposta_proponente)->
                    where('proposta.docente_inseriu_ficheiros', '!=', 1)->get();
        return $proposta;
    }
}
