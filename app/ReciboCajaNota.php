<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCajaNota extends Model
{
    protected $table='recibo_caja_nota';

    protected $fillable=[
    'id',
    'nota_credito_id',
    "recibo_caja_id"
    ];
}
