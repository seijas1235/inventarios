<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class meses extends Model
{
    protected $table='meses';

    protected $fillable=[
    'id',
    'mes'
    ];

    public function bg_corte_mensual(){
    	return $this->hasMany('App\bg_corte_mensual');
    }
}
