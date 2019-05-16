<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaCTC extends Model
{
    protected $table = 'proposta_ctc';

    protected $fillable = [
        'votos_a_favor', 'votos_contra', 'votos_brancos', 'votos_nulos', 'aprovacao', 'data_assinatura'
    ];

    protected $hidden = [];
}
