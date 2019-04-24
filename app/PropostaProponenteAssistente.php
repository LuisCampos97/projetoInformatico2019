<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponenteAssistente extends Model
{

    protected $table='proposta_proponente_assistente';

    protected $fillable =[
        'regime_prestacao_servicos', 'percentagem_prestacao_servicos', 'duracao', 'data_inicio_contrato',
        'data_fim_contrato', 'avaliacao_periodo_anterior', 'proposta_proponente_id'
    ];

    protected $hidden = [

    ];
}
