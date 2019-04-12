<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropostaDiretorUO extends JsonResource
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
            'reconhecimento' => $this->reconhecimento,
            'parecer' => $this->parecer,
            'data_assinatura' => $this->data_assinatura
        ];
    }
}
