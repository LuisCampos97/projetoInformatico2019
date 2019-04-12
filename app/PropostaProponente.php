<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaProponente extends Model
{
    protected $fillable = [
        'unidade_organica', 'nome_completo', 'departamento_id', 'unidade_curricular_id', 
        'data_de_assinatura_coordenador_departamento', 'data_de_assinatura_coordenador_de_curso'
    ];

    protected $hidden = [];
}
