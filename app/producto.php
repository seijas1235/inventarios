<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table='productos';

    protected $fillable=[
    'id',
    'codigobarra',
    'nombre',
    'descripcion',
    'aplicacion',
    'no_serie',
    'marca_id',
    'precio_venta',
    "precio_compra",
    'estado_producto_id',
    'tipo_producto_id',
    'user_id'
    ];



    public function marca(){
        return $this->belongsTo('App\marca');
    }

    public function estadoproducto(){
    	return $this->belongsTo('App\estado_producto');
    }

    public function tipoproducto(){
    	return $this->belongsTo('App\tipo_producto');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
