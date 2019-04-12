<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropostaProponenteProfessor extends JsonResource
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
            'role_professor' => $this->role_professor,
            'tipo_contrato' => $this->tipo_contrato,
            'regime_prestacao_servicos' => $this->regime_prestacao_servicos,
            'percentagem_prestacao_servicos' => $this->percentagem_prestacao_servicos,
            'duracao' => $this->duracao,
            'data_inicio_contrato' => $this->data_inicio_contrato,
            'data_fim_contrato' => $this->data_fim_contrato,
            'avaliacao_periodo_anterior' => $this->avaliacao_periodo_anterior
        ];
    }
}
