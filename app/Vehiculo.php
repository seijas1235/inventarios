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
        'marca_id',
        'tipo_transmision_id',
        'linea',
        'observaciones',
        'cliente_id'
        ];


    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function marca(){
        return $this->belongsTo(Marca::class);
    }

    public function tipo_transmision(){
        return $this->belongsTo(TipoTransmision::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
