<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_cuenta_contable extends Model
{
    protected $table='tipo_cuenta_contable';

    protected $fillable=[
    'id',
    'tipo_cuenta_contable'
    ];

    public function cuenta_contable(){
    	return $this->hasMany('App\cuenta_contable');
    }
}
