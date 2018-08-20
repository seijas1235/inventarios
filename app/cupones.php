<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cupones extends Model
{
    protected $table='cupones';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'no_cupon',
    'codigo_cliente',
    'nombre_cliente',
    'monto',
    'observaciones',
    'user_id',
    'estado_corte_id',
    'estado'
    ];

	public function user(){
		return $this->belongsTo('App\users');
	}

    public function estado_corte(){
        return $this->belongsTo('App\estado_corte');
    }
}