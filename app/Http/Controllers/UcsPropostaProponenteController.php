<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UcsPropostaProponente;
use App\Http\Resources\UcsPropostaProponente as UcsPropostaProponenteResource;

class UcsPropostaProponenteController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'codigo_uc' => 'required',
            'regime' => 'required',
            'tipo' => 'required',
            'horas' => 'required',
            'horas_semestrais' => 'required',
            'departamento_id' => 'nullable',
            'turno' => 'required'
        ]);
        $ucsPropostaProponente = new UcsPropostaProponente();
        $ucsPropostaProponente->fill($request->all());
        $ucsPropostaProponente->save();
        return (new UcsPropostaProponenteResource($ucsPropostaProponente))->response()->setStatusCode(201);
    }

}
