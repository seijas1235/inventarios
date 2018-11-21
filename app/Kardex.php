<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table='kardex';

	protected $fillable=[
	'id',
	'fecha',
	'transaccion',
	'producto_id',
	'ingreso',
	'salida',
	'existencia_anterior',
	'saldo'
	];
}
