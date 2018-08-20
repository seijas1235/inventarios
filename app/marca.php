<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class marca extends Model
{
    protected $table='marcas';

    protected $fillable=[
    'id',
    'marca',
    'user_id'
    ];

    public function modelo(){
    	return $this->hasMany('App\modelo');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
