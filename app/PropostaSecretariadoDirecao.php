<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaSecretariadoDirecao extends Model
{
    protected $table='proposta_secretariado_direcao';
    protected $fillable = [
        'convite'
    ];

    protected $hidden = [];
}
