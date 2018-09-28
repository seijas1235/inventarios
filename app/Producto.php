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
        'codigo_barra',
        'medida_id',
        'marca_id',
        'descripcion'
        ];

    public function precios_producto(){
        return $this->hasMany(PrecioProducto::class);
       }
    public function unidades_de_medida(){
        return $this->belongsTo(UnidadDeMedida::class);
    }
    public function proveedores(){
        return $this->belongsTo(Proveedor::class);
    }

}
