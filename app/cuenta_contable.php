<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cuenta_contable extends Model
{
    protected $table='cuenta_contable';

    protected $fillable=[
    'id',
    'codigo',
    'descripcion',
    'estacion_servicio_id',
    'tipo_cc_id',
    'user_id'
    ];

    public function requisicion(){
    	return $this->hasMany('App\requisicion');
    }

    public function tipo_cuenta_contable(){
    	return $this->belongsTo('App\tipo_cuenta_contable');
    }

    public function estacion_servicio(){
        return $this->belongsTo('App\estacion_servicio');
    }
}
