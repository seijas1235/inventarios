<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tanque extends Model
{
    protected $table='tanque';

    protected $fillable=[
    'id',
    'nombre_tanque',
    'combustible_id',
    'capacidad'
    ];

    public function inventario_combustible(){
    	return $this->hasMany('App\inventario_combustible');
    }

    public function combustible(){
    	return $this->belongsTo('App\combustible');
    }
}
