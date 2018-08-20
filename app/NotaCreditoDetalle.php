<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoDetalle extends Model
{
    protected $table='nota_credito_detalle';

    protected $fillable=[
    'id',
    'producto_id',
    "combustible_id",
    "user_id",
    "cantidad",
    "subtotal",
    "tipo_producto_id",
    "nota_credito_maestro_id"
    ];

        public function producto_id(){
        return $this->belongsTo('App\producto');
    }

    public function combustible(){
        return $this->belongsTo('App\combustible');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tipo_producto(){
        return $this->belongsTo('App\tipo_producto');
    }

    public function nota_maestro(){
        return $this->belongsTo('App\NotaCreditoMaestro');
    }

}
