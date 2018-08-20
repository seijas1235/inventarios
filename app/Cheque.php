<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $table='cheque';

    protected $fillable=[
    'id',
    'fecha_cheque',
    'no_cuenta_id',
    'no_cheque',
    'requisicion_id',
    'pagar_a',
    'monto',
    'monto_letras',
    'referencia',
    'user_crea_id',
    'fecha_imprime',
    'user_imprime_id',
    'razon_anulacion',
    'fecha_anulacion',
    'user_anula_id',
    'fecha_cobro',
    'user_reg_cobro_id',
    'estado_cheque_id'
    ];

    public function cuenta(){
        return $this->belongsTo('App\cuenta');
    }

    public function requisicion(){
        return $this->belongsTo('App\requisicion');
    }

    public function estado_cheque(){
        return $this->belongsTo('App\estado_cheque');
    }

    public function user(){
        return $this->belongsTo('App\user');
    }
}
