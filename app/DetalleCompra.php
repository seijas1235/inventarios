<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalles_compras';

    protected $fillable=[
        'id',
        'producto_id',
        'compra_id',
        'cantidad',
        'precio_costo',
        'subtotal',
        'maquinaria_equipo_id'
        ];

    public function maquinaria(){
        return $this->belongsTo(MaquinariaEquipo::class);
    }

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
