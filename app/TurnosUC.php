<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnosUC extends Model
{
    protected $table = 'turnos_uc';

    protected $fillable = [
        'codigo_uc', 'regime', 'turno'
    ];
}
