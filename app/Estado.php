<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    
    protected $fillable=[
        'id',
        'estado',
    ];

    public function series(){
        return $this->hasMany(Series::class);
    }

}
