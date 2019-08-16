<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{

    protected $table = 'proposta';

    protected $fillable = [
        'proposta_proponente_id', 'proposta_diretor_uo_id', 'proposta_ctc_id', 'proposta_secretariado_direcao_id',
        'docente_inseriu_ficheiros', 'proposta_recursos_humanos_id', 'status'
    ];

    protected $hidden = [];
}
