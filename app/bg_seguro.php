<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_seguro extends Model
{
     protected $table='bg_seguro';

    protected $fillable=[
    'id',
    'fecha_compra',
    'no_pedido',
    'no_carga',
    'gal_super',
    'gal_regular',
    'gal_diesel',
    'total_galones',
    'total_seguro',
    'estado_seguro_id',
    'estado',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function estado_seguro(){
        return $this->belongsTo('App\estado_seguro');
    }
}
