<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponenteProfessor extends Model
{

    protected $table='proposta_proponente_professor';

    protected $fillable = [
        'role_professor', 'tipo_contrato', 'regime_prestacao_servicos', 'percentagem_prestacao_servicos', 'duracao',
        'data_inicio_contrato', 'data_fim_contrato', 'avaliacao_periodo_anterior', 'proposta_proponente_id'
    ];

    protected $hidden = [
        
    ];

}
