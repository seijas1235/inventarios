<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class galones_mes extends Model
{
     protected $table='galones_mes';

    protected $fillable=[
    'id',
    'mes_id',
    'anio',
    'gals_super',
    'gals_regular',
    'gals_diesel',
    'estado',
    'user_id'
    ];

    public function mes(){
		return $this->belongsTo('App\meses');
	}


	public function user(){
		return $this->belongsTo('App\users');
	}
}
