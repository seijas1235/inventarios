<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class corte_caja extends Model
{
    protected $table='corte_caja';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'lubricantes',
    'gal_super',
    'total_super',
    'gal_regular',
    'total_regular',
    'gal_diesel',
    'total_diesel',
    'combustible',
    'total_ventas',
    'deposito_grande',
    'deposito_colas',
    'deposito_posterior',
    'total_efectivo',
    'tarjeta',
    'vales',
    'gastos',
    'devoluciones',
    'faltantes',
    'cupones',
    'anticipo_empleado',
    'calibraciones',
    'gastos_bg',
    'total_ventas_turno',
    'observaciones',
    'resultado_turno',
    'resultado_q',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }
}