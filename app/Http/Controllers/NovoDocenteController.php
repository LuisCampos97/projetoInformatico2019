<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropostaProponente;

class NovoDocenteController extends Controller
{
    public function getProposta($emailDocente){
        $proposta = PropostaProponente::where('email', $emailDocente)->get();
        return $proposta;
    }
}
