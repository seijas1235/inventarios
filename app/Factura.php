<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable=[
        'id',
        'numero',
        'fecha',
        'total',
        'voucher_id',
        'tipo_pago_id',
        'user_id',
        'serie_id',


        ];

    public function series(){
        return $this->belongsTo(Serie::class);
    }
    public function voucher(){
        return $this->belongsTo(Voucher::class);
    }
}
