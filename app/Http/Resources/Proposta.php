<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Proposta extends JsonResource
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
            'proposta_proponente_id' => $this->proposta_proponente_id,
            'proposta_diretor_uo_id' => $this->proposta_diretor_uo_id,
            'proposta_ctc_id' => $this->proposta_ctc_id,
            'proposta_secretariado_direcao_id' => $this->proposta_secretariado_direcao_id,
            'proposta_recursos_humanos_id' => $this->proposta_recursos_humanos_id
        ];
    }
}
