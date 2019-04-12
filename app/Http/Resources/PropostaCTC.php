<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropostaCTC extends JsonResource
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
            'votos_a_favor' => $this->votos_a_favor,
            'votos_contra' => $this->votos_contra,
            'votos_brancos' => $this->votos_brancos,
            'votos_nulos' => $this->votos_nulos,
            'aprovacao' => $this->aprovacao,
            'data_assinatura' => $this->data_assinatura
        ];
    }
}
