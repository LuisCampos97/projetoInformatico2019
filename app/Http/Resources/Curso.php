<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Curso extends JsonResource
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
           'nome_curso' => $this->nome_curso,
           'sigla' => $this->sigla,
           'departamento_id' => $this->departamento_id
        ];
    }
}
