<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCajaVale extends Model
{
    protected $table='recibo_caja_vale';

    protected $fillable=[
    'id',
    'vale_id',
    "recibo_caja_id",
    "total"
    ];
}
