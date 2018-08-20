<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class combustible extends Model
{
    
    protected $table='combustible';

    protected $fillable=[
    'id',
    'combustible',
    'tipo_servicio_id'
    ];

    public function tipo_servicio(){
    	return $this->belongsTo('App\tipo_servicio');
    }
}
