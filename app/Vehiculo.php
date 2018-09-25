<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table ='vehiculos';

    protected $fillable=[
        'id',
        'placa',
        'aceite',
        'kilometraje',
        'año',
        'tipo_vehiculo_id'
        ];


    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class);
    }
}
