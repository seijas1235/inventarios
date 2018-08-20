<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_inventario_combustible extends Model
{
    protected $table='tipo_inventario_combustible';

    protected $fillable=[
    'id',
    'tipo_inventario_combustible'
    ];

    public function inventario_combustible(){
    	return $this->hasMany('App\inventario_combustible');
    }
}
