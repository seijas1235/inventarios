<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaCambiariaDetalle extends Model
{
    protected $table='factura_cambiaria_detalle';

    protected $fillable=[
    'id',
    'factura_cambiaria_maestro_id',
    "cantidad",
    "subtotal",
    "producto_id",
    "tipo_producto_id",
    "combustible_id",
    "user_id"
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

    public function factura_maestro(){
        return $this->belongsTo('App\FacturaCambiariaMaestro');
    }
}
