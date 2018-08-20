<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gasto extends Model
{
     protected $table='gastos';

    protected $fillable=[
    'id',
    'fecha',
    "documento",
    "no_documento",
    "descripcion",
    "monto",
    "user_id",
    "fecha_corte",
    "estado_corte_id",
    "codigo_corte"
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }
}
