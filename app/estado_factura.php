<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_factura extends Model
{
    protected $table='estado_factura';

    protected $fillable=[
    'id',
    'estado_factura'
    ];

    public function factura(){
    	return $this->hasMany('App\factura');
    }
}
