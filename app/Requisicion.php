<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model
{
    protected $table='requisicion';

    protected $fillable=[
    'id',
    'no_requisicion',
    'fecha_requisicion',
    'empleado_solicita_id',
    'pagar_a',
    'cuenta_contable_id',
    'monto',
    'concepto',
    'user_crea_id',
    'razon_rechazo',
    'fecha_rechazo',
    'user_rechaza_id',
    'razon_autoriza',
    'fecha_autoriza',
    'user_autoriza_id',
    'razon_anulacion',
    'fecha_anulacion',
    'user_anula_id',
    'estado_requisicion_id'
    ];


    public function cheque(){
        return $this->hasMany('App\cheque');
    }

    public function empleado(){
        return $this->belongsTo('App\empleado');
    }

    public function cliente(){
        return $this->belongsTo('App\cliente');
    }

    public function cuenta_contable(){
        return $this->belongsTo('App\cuenta_contable');
    }

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function estado_requisicion(){
        return $this->belongsTo('App\estado_requisicion');
    }
}