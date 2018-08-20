<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_repuesto extends Model
{
    protected $table='bg_repuestos';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'documento',
    'no_documento',
    'descripcion',
    'monto',
    'observaciones',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function estado_corte(){
        return $this->belongsTo('App\estado_corte');
    }
}