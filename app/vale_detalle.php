<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vale_detalle extends Model
{
	protected $table='vale_detalle';

	protected $fillable=[
	'id',
	'vale_maestro_id',
	'producto_id',
	'combustible_id',
	'user_id',
	'cantidad',
	'precio_compra',
	'precio_venta',
	'subtotal',
	'tipo_producto_id'
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

	public function vale_maestro(){
    	return $this->belongsTo('App\vale_maestro');
    }


}
