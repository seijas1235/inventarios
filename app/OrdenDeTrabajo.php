<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenDeTrabajo extends Model
{
    protected $table = 'ordenes_de_trabajo';

    protected $fillable=[
        'id',
        'fecha_hora',
        'resp_recepcion',
        'fecha_prometida',
        'cliente_id',
        'vehiculo_id'
        ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class);
    }
}