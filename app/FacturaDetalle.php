<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $table='factura_detalle';

    protected $fillable=[
    'id',
    'factura_id',
    "cantidad",
    "subtotal",
    "producto_id",
    "tipo_producto_id",
    "combustible_id",
    "user_id"
    ];

    public function factura(){
        return $this->hasMany('App\factura');
    }

    public function producto(){
        return $this->belongsTo('App\producto');
    }

    public function tipo_producto(){
        return $this->belongsTo('App\tipo_producto');
    }

    public function combustible(){
        return $this->belongsTo('App\combustible');
    }

    public function user(){
        return $this->belongsTo('App\user');
    }
}
