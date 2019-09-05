<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeCurricular extends Model
{

    protected $table='unidade_curricular';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'codigo', 'nome', 'codigo_curso', 'departamento_id', 'tipo'
    ];

    protected $hidden = [];
}
