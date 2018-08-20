<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher_tarjeta extends Model
{
    protected $table='voucher_tarjetas';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'no_lote',
    'total',
    'observaciones',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function estado_corte(){
    	return $this->belongsTo('App\estado_corte');
    }

    public function user(){
    	return $this->belongsTo('App\user');
    }
}


