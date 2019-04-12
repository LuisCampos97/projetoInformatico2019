<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropostaDiretorUO extends Model
{
    protected $fillable = [
        'reconhecimento', 'parecer', 'data_assinatura'
    ];

    protected $hidden = [];
}
