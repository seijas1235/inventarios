<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_cuenta_empleado extends Model
{
    protected $table='estado_cuenta_empleado';

    protected $fillable=[
    'id',
    'fecha_transaccion',
    'empleado_id',
    'documento',
    'no_documento',
    'cargos',
    'abonos',
    'saldo',
    'descripcion',
    'estado',
    'user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function empleado(){
    	return $this->belongsTo('App\empleado');
    }
}
