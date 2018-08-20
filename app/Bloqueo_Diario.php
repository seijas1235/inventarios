<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloqueo_Diario extends Model
{
   protected $table='bloqueo_diario';

    protected $fillable=[
    'id',
    'fecha',
    'cliente_id',
    'accion',
    'razon',
    'user_id'
    ];

    
    public function cliente(){
    	return $this->belongsTo('App\cliente');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
