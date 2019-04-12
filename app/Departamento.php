<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'nome_departamento', 'sigla', 'coordenador_departamento', ''
    ];

    protected $hidden = [

    ];
}
