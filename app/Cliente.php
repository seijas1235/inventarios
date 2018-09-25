<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable=[
        'id',
        'nombres',
        'apellidos',
        'nit',
        'direccion',
        'telefonos',
        'record_compra',
        'tipo_cliente_id',
        'user_id'
        ];

    public function tipo_cliente(){
        return $this->belongsTo(TipoCliente::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}