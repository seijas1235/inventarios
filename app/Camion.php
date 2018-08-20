<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    protected $table='camion';

    protected $fillable=[
    'id',
    'nombre',
    'placa',
    'estado_id'
    ];

    public function compra_combustible(){
    	return $this->hasMany('App\CompraCombustibleMaestro');
    }

    public function bd_flete_maestro(){
        return $this->hasMany('App\bd_flete_maestro');
    }
}
