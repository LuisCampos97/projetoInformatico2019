<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Departamento extends JsonResource
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
            'departamento' => $this->departamento,
            'nome_departamento' => $this->nome_departamento,
            'sigla' => $this->sigla,
            'coordenador_departamento' => $this->coordenador_departamento
        ];
    }
}
