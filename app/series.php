<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class series extends Model
{
    protected $table='series';

    protected $fillable=[
    'id',
    'serie',
    'resolucion',
    'fecha_resolucion',
    'num_inferior',
    'num_superior',
    'fecha_vencimiento',
    'num_actual',
    'estado_serie_id',
    'documento_id',
    'user_id'
    ];

    public function serviciomaestro(){
    	return $this->hasMany('App\NotaCreditoMaestro');
    }

    public function bodega(){
    	return $this->hasMany('App\FacturaCambiariaMaestro');
    }

    public function empleadotienda(){
        return $this->hasMany('App\Factura');
    }

    public function documentos(){
        return $this->belongsTo('App\documentos');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
