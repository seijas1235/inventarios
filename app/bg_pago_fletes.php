<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_pago_fletes extends Model
{
    protected $table='bg_pago_flete';

    protected $fillable=[
    'id',
    'fecha_documento',
    'documento',
    'no_documento',
    'cargo',
    'abono',
    'saldo',
    'observaciones',
    'estado'
    ];
}
