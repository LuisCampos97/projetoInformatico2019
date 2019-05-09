<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ficheiro extends Model
{
    protected $table='ficheiro';

    public $timestamps = false;

    protected $fillable=[
        'nome', 'descricao', 'proposta_id'
    ];
}
