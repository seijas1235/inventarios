<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_vale extends Model
{
    protected $table='estado_vale';

    protected $fillable=[
    'id',
    'estado_vale'
    ];

    public function vale_maestro(){
    	return $this->hasMany('App\vale_maestro');
    }
}
