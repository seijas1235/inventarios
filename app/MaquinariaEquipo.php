<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaquinariaEquipo extends Model
{
    protected $table ='maquinarias_y_equipos';

    protected $fillable=[
        'id',
        'nombre_maquina',
        'codigo_maquina',
        'marca',
        'labadas_limite',
        'fecha_adquisicion',
        'precio_costo',
        'descripcion'
        ];
    public function mantto_equipo(){
        return $this->hasMany(MantenimientoEquipo::class);
    }
    public function marcas(){
        return $this->belongsTo(Marca::class);
    }
    public function servicios(){
        return $this->belongsToMany(Servicio::class);
    }
    public function detalles_compras(){
        return $this->hasMany(DetalleCompra::class);
    }
}
