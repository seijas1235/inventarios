<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_producto extends Model
{
    protected $table='estados_producto';

    protected $fillable=[
    'id',
    'estado_producto'
    ];

    public function producto(){
    	return $this->hasMany('App\producto');
    }
}
