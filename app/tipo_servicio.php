<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_servicio extends Model
{
     protected $table='tipo_servicio';

    protected $fillable=[
    'id',
    'tipo_servicio'
    ];

    public function combustible(){
    	return $this->hasMany('App\combustible');
    }
}
