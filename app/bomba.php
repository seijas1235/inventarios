<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bomba extends Model
{
    protected $table='bomba';

    protected $fillable=[
    'id',
    'bomba',
    'combustible_id',
    'user_id'
    ];
}
