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
        'precio',
        'precio_costo',
        'tipo_servicio_id'
        ];

    public function Maquinarias(){
        return $this->belongsToMany(MaquinariaEquipo::class);
    }
    public function tipo_servicio(){
        return $this->belongsTo(TipoServicio::class);
    }
}
