<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saldos_clientes extends Model
{
     protected $table='saldos_clientes';

    protected $fillable=[
    'id',
    'mes_id',
    'anio',
    'cliente_id',
    'saldo',
    'estado',
    'user_id'
    ];

    public function mes(){
		return $this->belongsTo('App\meses');
	}

	public function cliente(){
		return $this->belongsTo('App\cliente');
	}

	public function user(){
		return $this->belongsTo('App\users');
	}
}