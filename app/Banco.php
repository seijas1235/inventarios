<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table='banco';

    protected $fillable=[
    'id',
    'nombre',
    'estado_id'
    ];
}
