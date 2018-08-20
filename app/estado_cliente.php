<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_cliente extends Model
{
    protected $table='estados_cliente';

    protected $fillable=[
    'id',
    'estado_cliente'
    ];

    public function cliente(){
    	return $this->hasMany('App\cliente');
    }
}
