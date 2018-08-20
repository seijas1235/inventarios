<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaCobrarMaestro extends Model
{
	protected $table='cuenta_cobrar_maestro';

	protected $fillable=[
	'id',
	'cliente_id',
	'user_id',
	"estacion_id",
	"estado_cuenta_cobrar_id"
	];


	public function estado_cuenta(){
		return $this->belongsTo('App\estado_cuenta');
	}

	public function cliente(){
		return $this->belongsTo('App\cliente');
	}

		public function cuenta_detalle(){
		return $this->hasMany('App\CuentaCobrarDetalle');
	}


}
