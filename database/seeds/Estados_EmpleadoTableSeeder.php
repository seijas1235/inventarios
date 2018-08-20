<?php

use Illuminate\Database\Seeder;
use App\estado_empleado;

class Estados_EmpleadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eemp=new estado_empleado();
    	$eemp->estado_empleado="Activo";
    	$eemp->save();

    	$eemp=new estado_empleado();
    	$eemp->estado_empleado="Inactivo";
    	$eemp->save();

    	$eemp=new estado_empleado();
    	$eemp->estado_empleado="Suspendido";
    	$eemp->save();

    	$eemp=new estado_empleado();
    	$eemp->estado_empleado="Vacaciones";
    	$eemp->save();
    }
}
