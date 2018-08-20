<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedor extends Model
{
    protected $table='proveedores';

    protected $fillable=[
    'id',
    'nit',
    'nombre_comercial',
    'representante',
    'telefonos',
    'direccion',
    'cuentac',
    'user_id'
    ];

    public function compramaestro(){
    	return $this->hasMany('App\compra_maestro');
    }

    public function ordencompradetalle(){
        return $this->hasMany('App\orden_compra_detalle');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
