<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_producto extends Model
{
    protected $table='tipos_productos';

    protected $fillable=[
    'id',
    'tipo_producto'
    ];

    public function producto(){
    	return $this->hasMany('App\producto');
    }
}
