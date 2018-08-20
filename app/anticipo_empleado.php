<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anticipo_empleado extends Model
{
    protected $table='anticipo_empleados';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'empleado_id',
    'monto',
    'documento',
    'no_documento',
    'observaciones',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function estado_corte(){
    	return $this->belongsTo('App\estado_corte');
    }

    public function user(){
    	return $this->belongsTo('App\user');
    }

    public function empleado(){
    	return $this->belongsTo('App\empleado');
    }
}
