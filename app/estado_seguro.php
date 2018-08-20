<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_seguro extends Model
{
    protected $table='estado_seguro';

    protected $fillable=[
    'id',
    'estado_seguro'
    ];

    public function bg_seguro(){
    	return $this->hasMany('App\bg_seguro');
    }
}
