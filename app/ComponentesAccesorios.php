<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentesAccesorios extends Model
{
    protected $table = 'clientes';

    protected $fillable=[
        'id',
        'emblemas',
        'encendedor',
        'espejos',
        'antena',
        'radio',
        'llavero',
        'placas',
        'platos',
        'tampon_combustible',
        'soporte_bateria',
        'papeles',
        'alfombras',
        'control_alarma',
        'extinguidor',
        'triangulo',
        'vidrios_electricos',
        'conos',
        'neblineras',
        'luces',
        'llanta_repusto',
        'llave_ruedas',
        'tricket',
        'descripcion',
        'orden_id'
    ];

    public function orden_trabajo(){
        return $this->belongsTo(OrdenDeTrabajo::class);
    }
}