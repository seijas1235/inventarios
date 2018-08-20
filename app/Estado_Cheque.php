<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_Cheque extends Model
{
    protected $table='estado_cheque';

    protected $fillable=[
    'id',
    'estado_cheque'
    ];

    public function cheque(){
    	return $this->hasMany('App\cheque');
    }
}
