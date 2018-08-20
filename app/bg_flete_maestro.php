<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_flete_maestro extends Model
{
        protected $table='bg_fletes_maestro';

    protected $fillable=[
    'id',
    'fecha_corte',
    'codigo_corte',
    'proveedor_id',
    'camion_id',
    'destino_id',
    'no_pedido',
    'no_carga',
    'serie_factura',
    'no_factura',
    'gal_super',
    'gal_regular',
    'gal_diesel',
    'total_galones',
    'total_compra',
    'observaciones',
    'estado_corte_id',
    'estado',
    'user_id'
    ];

    public function bg_flete_detalle(){
        return $this->belongsTo('App\bg_flete_detalle');
    }

    public function proveedor(){
        return $this->belongsTo('App\proveedor');
    }

    public function estado_corte(){
        return $this->belongsTo('App\estado_corte');
    }

    public function camion(){
        return $this->belongsTo('App\camion');
    }

    public function destino(){
        return $this->belongsTo('App\destino');
    }

    public function user(){
        return $this->belongsTo('App\user');
    }
}
