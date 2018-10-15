<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentesAccesorios extends Model
{
    protected $table = 'clientes';

    protected $fillable=[
        'id',
        'emblemas',
        'encendedir',
        'espejos',
        'antena',
        'radio',
        'llavero',
        'placas',
        'platos',
        'tampon_combustible',
        'soporte_bateria',
        'paleles',
        'alfombras',
        'control_alarma',
        'extinguido',
        'triangulo',
        'vidrios_electricos',
        'conos',
        'nebline',
        'luces',
        'llanta_repusto',
        'llave_ruedas',
        'tricket',
        'descripcion',
        'orden_id'
    ];

    public function orden_trabajo(){
        return $this->hasMany(OrdenDeTrabajo::class);
    }
}