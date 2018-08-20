<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_corte_mensual extends Model
{
     protected $table='bg_corte_mensual';

    protected $fillable=[
    'id',
    'mes_id',
    'total_galones',
    'total_ingreso',
    'total_impuesto',
    'total_seguro',
    'total_repuestos',
    'total_viaticos',
    'total_salarios',
    'total_combustible',
    'total_mantenimientos',
    'total_contabilidad',
    'total_gastos_bg',
    'utilidad_bg',
    'estado',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function mes(){
        return $this->belongsTo('App\mes');
    }
}