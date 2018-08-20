<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cargo_empleado extends Model
{
    protected $table='cargos_empleado';

    protected $fillable=[
    'id',
    'cargo_empleado'
    ];

    public function empleado(){
    	return $this->hasMany('App\empleado');
    }
}
