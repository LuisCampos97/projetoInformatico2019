<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeCurricular extends Model
{

    protected $table='unidade_curricular';

    protected $fillable = [
        'nome', 'departamento_id', 'regime', 'tipo', 'turno'
    ];

    protected $hidden = [];
}
