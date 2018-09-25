<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    protected $table = 'marcas_vehiculo';
    protected $fillable=[
        'id', 'nombre'
    ];

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
       }
}
