<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bomba_Combustible extends Model
{
    protected $table='bomba_combustible';

    protected $fillable=[
    'id',
    'bomba_id',
    'combustible_id',
    'user_id'
    ];

    public function estadocliente(){
        return $this->belongsTo('App\bomba');
    }

    public function tipo_cliente(){
        return $this->belongsTo('App\combustible');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
