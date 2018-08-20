<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class idp extends Model
{
     protected $table='idps';

    protected $fillable=[
    'id',
    'combustible_id',
    'costo_idp',
    'user_id'
    ];

    public function combustible(){
    	return $this->belongsTo('App\combustible');
    }

    public function users(){
    	return $this->belongsTo('App\user');
    }
}
