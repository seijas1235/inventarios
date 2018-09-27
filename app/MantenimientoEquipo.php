<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MantenimientoEquipo extends Model
{
    protected $table = 'mantto_equipo';
    
    protected $fillable=[
        'id',
        'descripcion',
        'fecha_proximo_servicio',
        'fecha_servicio',
        'labadas_servicio',
        'labadas_proximo_servicio',
        'maquinaria_id'
        ];

    public function maquinarias_y_equipo(){
        return $this->belongsTo(MaquinariaEquipo::class);
    }
}
