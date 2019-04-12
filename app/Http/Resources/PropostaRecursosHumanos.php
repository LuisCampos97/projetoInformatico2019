<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropostaRecursosHumanos extends JsonResource
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
            'remuneracao' => $this->remuneracao,
            'escalao' => $this->escalao,
            'indice' => $this->indice,
            'numero_funcionario' => $this->numero_funcionario,
            'contratacao_comunicada' => $this->contratacao_comunicada,
            'inscricao_seguranca_social' => $this->inscricao_seguranca_social,
            'inscricao_caiga_geral_aposentacoes' => $this->inscricao_caiga_geral_aposentacoes,
            'despacho_presidente_ipl' => $this->despacho_presidente_ipl,
            'contrato_redigido' => $this->contrato_redigido,
            'contrato_anexo' => $this->contrato_anexo,
            'cessacao_social' => $this->cessacao_social,
            'NISS_ou_numero_CGA' => $this->NISS_ou_numero_CGA,
            'data_nascimento' => $this->data_nascimento,
            'numero_CC' => $this->numero_CC,
            'email' => $this->email,
            'dados_GIAF_carregados_por' => $this->dados_GIAF_carregados_por,
            'data_carregamento_dados_GIAF' => $this->data_carregamento_dados_GIAF
        ];
    }
}
