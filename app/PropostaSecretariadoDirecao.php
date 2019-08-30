<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaSecretariadoDirecao extends Model
{
    protected $table='proposta_secretariado_direcao';
    protected $primaryKey = 'id_proposta_secretariado_direcao';

    protected $fillable = [
        'convite', 'secretariado_direcao_id'
    ];

    protected $hidden = [];
}
