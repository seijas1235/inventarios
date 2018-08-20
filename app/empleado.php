<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empleado extends Model
{
    protected $table='empleados';

    protected $fillable=[
    'id',
    'emp_cui',
    'emp_nombres',
    'emp_apellidos',
    'emp_direccion',
    'emp_telefonos',
    'estado_empleado_id',
    'cargo_empleado_id',
    'tienda_id',
    'user_id'
    ];

    public function serviciomaestro(){
    	return $this->hasMany('App\servicio_maestro');
    }

    public function bodega(){
    	return $this->hasMany('App\bodega');
    }

    public function requisicion(){
        return $this->hasMany('App\requisicion');
    }

    public function empleadotienda(){
        return $this->hasMany('App\empleado_tienda');
    }

    public function userempleado(){
        return $this->hasMany('App\user_empleado');
    }

    public function tienda(){
    	return $this->belongsTo('App\tienda');
    }

    public function cargoempleado(){
    	return $this->belongsTo('App\cargo_empleado');
    }

    public function estadoempleado(){
    	return $this->belongsTo('App\estado_empleado');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
