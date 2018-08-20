<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_vehiculo extends Model
{
	protected $table='tipo_vehiculo';

	protected $fillable=[
	'id',
	'tipo_vehiculo',
	'user_id'
	];

	public function vale_maestro(){
		return $this->hasMany('App\vale_maestro');
	}

	public function user(){
        return $this->belongsTo('App\user');
    }
}
