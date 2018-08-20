<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estacion_servicio extends Model
{
    protected $table='estacion_servicio';

    protected $fillable=[
    'id',
    'nombre_estacion',
    'ubicacion'
    ];

    public function cuenta_contable(){
    	return $this->hasMany('App\cuenta_contable');
    }
}

