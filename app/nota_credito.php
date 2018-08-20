<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nota_credito extends Model
{
    protected $table='notas_creditos';

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

