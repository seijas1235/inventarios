<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_cuenta extends Model
{
    protected $table='estado_cuenta_cobrar';

    protected $fillable=[
    'id',
    'estado_cuenta_cobrar'
    ];

    public function cuenta_cobrar_detalle(){
    	return $this->hasMany('App\CuentaCobrarMaestro');
    }
}
