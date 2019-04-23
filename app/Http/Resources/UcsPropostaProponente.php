<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UcsPropostaProponente extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'nome_unidade_curricular' => $this->nome_unidade_curricular,
            'regime' => $this->regime,
            'tipo' => $this->tipo,
            'horas' => $this->horas,
            'horas_semestrais' => $this->horas_semestrais,
            'departamento_id' => $this->departamento_id,
            'proposta_proponente_id' => $this->proposta_proponente_id,
            'turno' => $this->turno
        ];
    }
}
