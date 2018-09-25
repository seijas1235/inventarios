<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable=[
        'id',
<<<<<<< HEAD
        'nombres',
        'apellidos',
=======
        'nombre',
        'apellido',
>>>>>>> 2392ad32391669dc4fdd376c2a547a1895605fd5
        'nit',
        'direccion',
        'telefonos',
        'puesto_id',
        ];

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }
}
