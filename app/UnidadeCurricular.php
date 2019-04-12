<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeCurricular extends Model
{
    protected $fillable = [
        'nome', 'departamento_id', 'regime', 'tipo', 'horas', 'horas_semestrais'
    ];

    protected $hidden = [];
}
