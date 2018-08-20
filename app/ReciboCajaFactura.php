<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCajaFactura extends Model
{
    protected $table='recibo_caja_factura';

    protected $fillable=[
    'id',
    'factura_cambiaria_id',
    "recibo_caja_id"
    ];

}
