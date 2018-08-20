<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table='cuenta';

    protected $fillable=[
    'id',
    'no_cuenta',
    'banco_id',
    'nombre_cuenta',
    'tipo_cuenta_id',
    'user_id'
    ];

    public function requisicion(){
    	return $this->hasMany('App\requisicion');
    }

    public function cheque(){
    	return $this->hasMany('App\cheque');
    }

    public function banco(){
    	return $this->belongsTo('App\banco');
    }

    public function tipo_cuenta(){
    	return $this->belongsTo('App\tipo_cuenta');
    }

    public function user(){
    	return $this->belongsTo('App\user');
    }
}
