<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_Requisicion extends Model
{
    protected $table='estado_requisicion';

    protected $fillable=[
    'id',
    'estado_requisicion'
    ];

    public function requisicion(){
    	return $this->hasMany('App\requisicion');
    }
}
