<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaCobrarDetalle extends Model
{
    protected $table='cuenta_cobrar_detalle';

	protected $fillable=[
	'id',
	'cuenta_cobrar_maestro_id',
	'tipo_transaccion',
	'fecha_documento',
	"documento_id",
	"total",
	"saldo",
	"estado_cuenta_cobrar_id",
	"user_id"
	];
}
