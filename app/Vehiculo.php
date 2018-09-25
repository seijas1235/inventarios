<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table ='vehiculos';

    protected $fillable=[
        'id',
        'placa',
        'aceite_caja',
        'aceite_motor',
        'kilometraje',
        'color',
        'fecha_ultimo_servicio',
        'año',
        'tipo_vehiculo_id',
        'marca_vehiculo_id'
        ];


    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function marca_vehiculo(){
        return $this->belongsTo(MarcaVehiculo::class);
    }
}
