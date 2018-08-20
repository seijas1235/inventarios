<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class documentos extends Model
{
    protected $table='documentos';

    protected $fillable=[
    'id',
    'documento'
    ];

    public function serviciomaestro(){
    	return $this->hasMany('App\series');
    }

}
