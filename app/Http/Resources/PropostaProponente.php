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
            'data_de_assinatura_coordenador_departamento' => $this->data_de_assinatura_coordenador_departamento,
            'tipo_contrato' => $this->tipo_contrato,
            'data_de_assinatura_coordenador_de_curso' => $this->data_de_assinatura_coordenador_de_cursom
        ];
    }
}
