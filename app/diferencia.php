<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class diferencia extends Model
{
    protected $table='diferencias_combustible';

    protected $fillable=[
    'id',
    'fecha',
    'combustible_id',
    'gal_inicio_mes',
    'gal_venta_dia',
    'gal_sistema_comb',
    'gal_comprados',
    'gal_descargados',
    'dif_gal_descargados',
    'saldo_gals',
    'dif_dia',
    'dif_acumulada_mes',
    'observaciones',
    'user_id',
    'estado'
    ];

    public function combustible(){
		return $this->belongsTo('App\combustible');
	}

	public function user(){
		return $this->belongsTo('App\users');
	}
}

