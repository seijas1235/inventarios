<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoProducto extends Model
{
    protected $table='movimientos_productos';

    protected $fillable=[
    'id',
    'fecha_ingreso',
    'producto_id',
    'existencias',
    'precio_compra',
    'precio_venta'
    ];

    public function producto(){
        return $this->belongsTo('App\Producto');
    }

    public function compras(){
        return $this->belongsTo('App\Compra');
    }

    public function detallescompras(){
        return $this->hasMany('App\DetalleCompra');
    }

    public function ventadetalle(){
        return $this->hasMany('App\VentaDetalle');
    }

    public function salidaproducto(){
        return $this->hasMany('App\SalidaProducto');
    }

}
