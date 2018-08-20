<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nota_facturas extends Model
{
    protected $table='nota_facturas';

    protected $fillable=[
    'id',
    'nota_credito_id',
    "factura_cambiaria_id"
    ];


    public function nota_maestro(){
        return $this->belongsTo('App\NotaCreditoMaestro');
    }


    public function factura_maestro(){
        return $this->belongsTo('App\FacturaCambiariaMaestro');
    }
}
