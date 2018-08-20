<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Cuenta extends Model
{
    protected $table='tipo_cuenta';

    protected $fillable=[
    'id',
    'tipo_cuenta'
    ];

    public function cuenta(){
    	return $this->hasMany('App\Cuenta');
    }
}
