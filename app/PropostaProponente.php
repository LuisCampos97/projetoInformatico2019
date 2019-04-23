<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponente extends Model
{

    protected $table = 'proposta_proponente';
    protected $fillable = [
        'unidade_organica', 'nome_completo', 'data_de_assinatura_coordenador_departamento', 'tipo_contrato'
    ];

    protected $hidden = [];
}
