<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_empleado extends Model
{
    protected $table='estados_empleado';

    protected $fillable=[
    'id',
    'estado_empleado'
    ];

    public function empleado(){
    	return $this->hasMany('App\empleado');
    }
}
