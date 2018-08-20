<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoMaestro extends Model
{
    protected $table='nota_credito_maestro';

    protected $fillable=[
    'id',
    "cliente_id",
    "user_id",
    "codigo_id",
    "estado_id",
    "tipo_id",
    "concepto_id",
    "monto",
    "idp_regular",
    "idp_super",
    "idp_diesel",
    "idp_total",
    "fecha"

    ];

    public function nota_detalle(){
        return $this->hasMany('App\NotaCreditoDetalle');
    }

    public function cliente(){
        return $this->belongsTo('App\cliente');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
