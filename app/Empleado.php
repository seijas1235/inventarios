<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable=[
        'id',
        'nombre',
        'apellido',
        'nit',
        'direccion',
        'telefonos',
        'puesto_id',
        ];

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }
}
