<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable=[
        'id',
        'nombre',
        'minimo',
        'codigo_barra'
        ];

    public function precios_producto(){
        return $this->hasMany(PrecioProducto::class);
       }
}
