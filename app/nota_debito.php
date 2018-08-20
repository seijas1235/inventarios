<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nota_debito extends Model
{
    protected $table='notas_debitos';

    protected $fillable=[
    'id',
    'anio',
    'fecha',
    "cliente_id",
    "total",
    "descripcion",
    "estado",
    "user_id"
    ];
    
    public function cliente(){
        return $this->belongsTo('App\cliente');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
