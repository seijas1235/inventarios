<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class medidas_tanques extends Model
{
    protected $table='medidas_tanques';

    protected $fillable=[
    'id',
    'fecha_medida',
    'med_regla_super',
    'med_regla_regular',
    'med_regla_diesel',
    'med_tabla_super',
    'med_tabla_regular',
    'med_tabla_diesel',
    'empleado_id',
    'user_id',
    'observaciones',
    'estado'
    ];

    public function empleado(){
		return $this->belongsTo('App\empleado');
	}

	public function user(){
		return $this->belongsTo('App\users');
	}
}
