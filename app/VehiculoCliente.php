<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiculoCliente extends Model
{
    protected $table ='vehiculos_cliente';

    protected $fillable=[
        'id',
        'cliente_id',
        'vehiculo_id'
        ];


    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
