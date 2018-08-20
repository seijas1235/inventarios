<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_transaccion extends Model
{
    protected $table='tipo_transaccion';

    protected $fillable=[
    'id',
    'tipo_transaccion'
    ];

    public function cuentacobrardetalle(){
    	return $this->hasMany('App\CuentaCobrarDetalle');
    }
}
