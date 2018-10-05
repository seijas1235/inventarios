<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    
    protected $fillable=[
        'id',
        'codigo',
        'nombre',
        'precio'
        ];

    public function Maquinarias(){
        return $this->belongsToMany(MaquinariaEquipo::class);
    }
}
