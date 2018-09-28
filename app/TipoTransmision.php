<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransmision extends Model
{
    protected $table = 'tipos_transmision';
    protected $fillable=[
        'id', 'nombre'
    ];

    public function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }
}
