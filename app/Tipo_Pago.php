<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Pago extends Model
{
    protected $table='tipos_pagos';

    protected $fillable=[
    'id',
    'tipo_pago'
    ];

    public function recibocaja(){
    	return $this->hasMany('App\ReciboCaja');
    }
}
