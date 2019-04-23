<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UcsPropostaProponente extends Model
{
    public $timestamps = false;

    protected $table = 'ucs_proposta_proponente';

    protected $fillable = [
        'nome_unidade_curricular', 'regime', 'tipo', 'horas', 'horas_semestrais', 'departamento_id', 'proposta_proponente_id', 'turno'
    ];

    
}
