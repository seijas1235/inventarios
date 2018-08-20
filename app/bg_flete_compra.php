<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_flete_compra extends Model
{
    protected $table='bg_flete_compra';

    protected $fillable=[
    'id',
    'bg_flete_maestro_id',
    'total_galones',
    'total_flete',
    'estado_flete_id',
    'estado'
    ];

    public function bg_flete_maestro(){
        return $this->hasMany('App\bg_flete_maestro');
    }

    public function estado_flete(){
        return $this->belongsTo('App\estado_flete');
    }
}
