<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table='clientes';

    protected $fillable=[
    'id',
    'cl_nit',
    'cl_nombres',
    'cl_apellidos',
    'cl_telefonos',
    'cl_direccion',
    'cl_montomaximo',
    'cl_mail',
    'cl_cuentac',
    'cl_saldo',
    'fecha_saldo',
    'estado_cliente_id',
    'tipo_cliente_id',
    'user_id'
    ];

    public function cotizacionmaestro(){
    	return $this->hasMany('App\cotizacion_maestro');
    }

    public function cheque(){
        return $this->hasMany('App\cheque');
    }

    public function requisicion(){
        return $this->hasMany('App\requisicion');
    }

    public function cuentaporcobrarmaestro(){
    	return $this->hasMany('App\cuenta_por_cobrar_maestro');
    }

    public function movimientoctaxcobrar(){
    	return $this->hasMany('App\movimiento_cuenta_por_cobrar');
    }

	public function ordenmaestro(){
    	return $this->hasMany('App\orden_maestro');
    }

    public function vehiculo(){
    	return $this->hasMany('App\vehiculo');
    }


    public function estadocliente(){
        return $this->belongsTo('App\estado_cliente');
    }

    public function tipo_cliente(){
        return $this->belongsTo('App\Tipo_Cliente');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
