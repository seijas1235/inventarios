<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    
    protected $fillable=[
        'id',
        'nombre',
        'precio'
        ];

    public function MaquinariasEquipos(){
        return $this->belongsToMany(MaquinariaEquipo::class);
    }
}
