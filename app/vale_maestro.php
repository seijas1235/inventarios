<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class vale_maestro extends Model
{
	protected $table='vale_maestro';

	protected $fillable=[
	'id',
	'total_vale',
	'user_id',
	'estado_vale_id',
	'cliente_id',
	'tipo_vehiculo_id',
	'piloto',
	'placa',
	'bomba_id',
	"idp_regular",
	"idp_super",
	"idp_diesel",
	"idp_total",
	"no_vale",
	"total_pagado",
	"total_por_pagar",
	"observaciones",
	"estado_corte_id",
	"tipo_servicio",
	"fecha_corte",
	"codigo_corte"
	];



	public function estado_vale(){
		return $this->belongsTo('App\estado_vale');
	}

	public function cliente(){
		return $this->belongsTo('App\cliente');
	}

	public function tipo_vehiculo(){
		return $this->belongsTo('App\tipo_vehiculo');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function bomba(){
		return $this->belongsTo('App\bomba');
	}

	public function vale_detalle(){
		return $this->hasMany('App\vale_detalle');
	}

	public function getFechaCorteAttribute($value)
	{
		return  Carbon::parse($value)->format('d-m-Y');
	}
}
