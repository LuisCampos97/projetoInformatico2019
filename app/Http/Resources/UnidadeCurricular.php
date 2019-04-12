<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnidadeCurricular extends JsonResource
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
            'nome' => $this->nome,
            'departamento_id' => $this->departamento_id,
            'regime' => $this->regime,
            'tipo' => $this->tipo,
            'horas' => $this->horas,
            'horas_semestrais' => $this->horas_semestrais
        ];
    }
}
