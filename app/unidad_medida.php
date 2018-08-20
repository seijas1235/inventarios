<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unidad_medida extends Model
{
    protected $table='unidad_medida';

	protected $fillable=[
	'id',
	'unidad_medida',
	'user_id'
	];

	public function factura_lub_detalle(){
		return $this->hasMany('App\factura_lub_deetalle');
	}

	public function user(){
        return $this->belongsTo('App\user');
    }
}
