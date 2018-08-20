<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table='destino';

    protected $fillable=[
    'id',
    'nombre',
    'estado_id'
    ];

    public function compra_combustible(){
    	return $this->hasMany('App\CompraCombustibleMaestro');
    }
}
