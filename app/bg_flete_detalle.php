<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_flete_detalle extends Model
{
    protected $table='bg_fletes_detalle';

    protected $fillable=[
    'id',
    'bg_flete_maestro_id',
    'combustible_id',
    'tanque_id',
    'galones',
    'precio_compra',
    'subtotal'
    ];

    public function combustible(){
        return $this->belongsTo('App\combustible');
    }

    public function tanque(){
        return $this->belongsTo('App\tanque');
    }

    public function bg_flete_maestro(){
        return $this->hasMany('App\bg_flete_maestro');
    }
}

