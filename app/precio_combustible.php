<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class precio_combustible extends Model
{
	protected $table='precio_combustible';

	protected $fillable=[
	'id',
	'precio_compra',
	'precio_venta',
	'combustible_id',
	];

	public function combustible(){
		return $this->belongsTo('App\combustible');
	}
}
