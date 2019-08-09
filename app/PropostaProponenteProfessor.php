<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponenteProfessor extends Model
{

    protected $table = 'proposta_proponente_professor';
    protected $primaryKey = 'id_proposta_proponente_professor';

    protected $fillable = [
        'role_professor', 'tipo_contrato', 'regime_prestacao_servicos', 'fundamentacao', 'percentagem_prestacao_servicos',
        'periodo', 'duracao', 'avaliacao_periodo_anterior', 'proposta_proponente_id'
    ];

    protected $hidden = [];
}
