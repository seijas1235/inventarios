<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Cliente extends Model
{
    protected $table='tipo_cliente';

    protected $fillable=[
    'id',
    'tipo_cliente'
    ];

    public function cliente(){
    	return $this->hasMany('App\cliente');
    }
}
