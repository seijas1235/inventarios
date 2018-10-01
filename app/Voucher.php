<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'estados';
    
    protected $fillable=[
        'id',
        'numero',
        'fecha',
    ];

    public function facturas(){
        return $this->hasMany(Factura::class);
    }
}
