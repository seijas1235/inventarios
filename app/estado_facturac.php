<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_facturac extends Model
{
    protected $table='estado_facturac';

    protected $fillable=[
    'id',
    'estado_facturac'
    ];

    public function factura_cambiaria_maestro(){
    	return $this->hasMany('App\FacturaCambiariaMaestro');
    }
}
