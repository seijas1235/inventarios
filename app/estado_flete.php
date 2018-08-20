<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_flete extends Model
{
    protected $table='estado_flete';

    protected $fillable=[
    'id',
    'estado_flete'
    ];

    public function bg_flete_compra(){
    	return $this->hasMany('App\bg_flete_compra');
    }
}
