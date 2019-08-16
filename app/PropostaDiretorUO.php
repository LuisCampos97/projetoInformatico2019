<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaDiretorUO extends Model
{
    protected $table = 'proposta_diretor_uo';
    protected $primaryKey = 'id_proposta_diretor_uo';

    protected $fillable = [
        'reconhecimento', 'parecer', 'data_assinatura'
    ];

    protected $hidden = [];
}
