<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable=[
        'id',
        'fecha',
        'proveedor_id',
        'total'
        ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
}
