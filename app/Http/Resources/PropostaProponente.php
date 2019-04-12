<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropostaProponente extends JsonResource
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
            'unidade_organica' => $this->unidade_organica,
            'nome_completo' => $this->nome_completo,
            'departamento_id' => $this->departamento_id,
            'unidade_curricular_id' => $this->unidade_curricular_id,
            'data_de_assinatura_coordenador_departamento' => $this->data_de_assinatura_coordenador_departamento
        ];
    }
}
