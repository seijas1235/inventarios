<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_corte extends Model
{
    protected $table='estado_corte';

    protected $fillable=[
    'id',
    'estado_corte'
    ];

    public function gasto(){
    	return $this->hasMany('App\gasto');
    }

    public function vale(){
    	return $this->hasMany('App\vale');
    }

    public function bg_combustible(){
    	return $this->hasMany('App\bg_combustible');
    }

    public function bg_flete_maestro(){
    	return $this->hasMany('App\bg_flete_maestro');
    }

    public function bg_mantenimiento(){
    	return $this->hasMany('App\bg_mantenimiento');
    }

    public function bg_repuesto(){
    	return $this->hasMany('App\bg_repuesto');
    }

    public function bg_salario(){
    	return $this->hasMany('App\bg_salario');
    }

    public function bg_seguro(){
    	return $this->hasMany('App\bg_seguro');
    }

    public function bg_viatico(){
    	return $this->hasMany('App\bg_viatico');
    }

    public function anticipo_empleado(){
        return $this->hasMany('App\anticipo_empleado');
    }

    public function voucher_tarjeta(){
        return $this->hasMany('App\voucher_tarjeta');
    }
}
