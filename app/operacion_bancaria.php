<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class operacion_bancaria extends Model
{
    protected $table='operacion_bancaria';

    protected $fillable=[
    'id',
    'fecha_transaccion',
    'cuenta_id',
    'documento_id',
    'no_documento',
    'debitos',
    'creditos',
    'saldo',
    'descripcion',
    'estado',
    'user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function documento(){
    	return $this->belongsTo('App\documento');
    }
}