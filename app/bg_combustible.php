<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_combustible extends Model
{
    protected $table='bg_combustible';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'no_vale',
    'conductor_id',
    'galones',
    'precio_unitario',
    'monto',
    'observaciones',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function empleado(){
        return $this->belongsTo('App\empleado');
    }

    public function estado_corte(){
        return $this->belongsTo('App\estado_corte');
    }
}