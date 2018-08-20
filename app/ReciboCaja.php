<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCaja extends Model
{
    protected $table='recibo_caja';

    protected $fillable=[
    'id',
    'fecha_recibo',
    'no_recibo_caja',
    "nit",
    "cliente_id",
    "user_id",
    "banco_id",
    "saldo_anterior",
    "saldo_actual",
    "monto",
    "tipo_pago_id",
    "concepto_id",
    "cheque", 
"observaciones",
    "estado_id",
    "monto_pagado"
    ];


    public function recibo_factura(){
        return $this->hasMany('App\ReciboCajaFactura');
    }

    public function recibo_nota(){
        return $this->hasMany('App\ReciboCajaNota');
    }
}
