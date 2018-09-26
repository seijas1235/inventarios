<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends Model
{
    protected $table = 'unidades_de_medida';
    protected $fillable=[
        'id', 'descripcion','cantidad'
    ];
}
