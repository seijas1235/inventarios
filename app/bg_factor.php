<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bg_factor extends Model
{
    protected $table='bg_factores';

    protected $fillable=[
    'id',
    'factor_calc',
    'indice'
    ];
}
