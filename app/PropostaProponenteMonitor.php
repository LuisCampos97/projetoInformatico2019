<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponenteMonitor extends Model
{

    protected $table = 'proposta_proponente_monitor';

    protected $fillable = [
        'regime_prestacao_servicos', 'percentagem_prestacao_servicos', 'duracao', 
        'data_inicio_contrato', 'data_fim_contrato', 'proposta_proponente_id'
    ];

    protected $hidden = [

    ];
}
