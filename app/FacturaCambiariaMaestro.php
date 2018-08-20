<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaCambiariaMaestro extends Model
{
	protected $table='factura_cambiaria_maestro';

	protected $fillable=[
	'id',
	'user_id',
	'cliente_id',
	"serie_id",
	"estado_id",
	"no_factura",
	"nit",
	"direccion",
	"total",
	"idp_regular",
	"idp_super",
	"idp_diesel",
	"idp_total",
	"fecha_factura",
	"total_pagado",
	"total_por_pagar"
	];


	public function factura_detalle(){
		return $this->hasMany('App\FacturaCambiariaDetalle');
	}

	public function cliente(){
		return $this->belongsTo('App\cliente');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}
}
