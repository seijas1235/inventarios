<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table='factura';

	protected $fillable=[
	'id',
	'user_id',
	"serie_id",
	"estado_id",
	"no_factura",
	"nit",
    "cliente",
	"direccion",
	"total",
    "idp_regular",
    "idp_super",
    "idp_diesel",
    "idp_total",
	"fecha_factura"
	];


    public function serie(){
        return $this->belongsTo('App\serie');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function estado(){
        return $this->belongsTo('App\estado');
    }

    public function factura_detalle(){
        return $this->hasMany('App\FacturaDetalle');
    }
}
