<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class faltante extends Model
{
     protected $table='faltantes';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'documento',
    'no_documento',
    'cliente_id',
    'monto',
    'descripcion',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function estado_corte(){
    	return $this->belongsTo('App\estado_corte');
    }

    public function user(){
    	return $this->belongsTo('App\user');
    }

}
