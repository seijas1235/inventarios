<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaquinariaEquipo extends Model
{
    protected $table ='maquinarias_y_equipos';

    protected $fillable=[
        'id',
        'nombre',
        'marca',
        'labadas_limite',
        'fecha_adquisicion',
        'precio_costo',
        ];

}
