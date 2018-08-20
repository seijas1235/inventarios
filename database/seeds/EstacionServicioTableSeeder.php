<?php

use Illuminate\Database\Seeder;
use App\estacion_servicio;

class EstacionServicioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $est=new estacion_servicio();
    	$est->nombre_estacion="Oficinas Centrales";
    	$est->ubicacion="Bo Santa Ana, Zona 2, Esquipulas, Chiquimula";
    	$est->save();

    	$est=new estacion_servicio();
    	$est->nombre_estacion="El Mirador";
    	$est->ubicacion="KM 222, Carretera a Esquipulas, Chiquimula";
    	$est->save();

    	$est=new estacion_servicio();
    	$est->nombre_estacion="Teculután";
    	$est->ubicacion="KM 121.5, carretera al Atlántico, Teculután, Zacapa";
    	$est->save();

    	$est=new estacion_servicio();
    	$est->nombre_estacion="Sanarate";
    	$est->ubicacion="KM 56.5, carretera al Atlántico, Sanarate, El Progreso";
    	$est->save();

    	$est=new estacion_servicio();
    	$est->nombre_estacion="Cadenas";
    	$est->ubicacion="KM 198 CA13, Modesto Mendez, Livingston, Izabal";
    	$est->save();

    	$est=new estacion_servicio();
    	$est->nombre_estacion="Melchor de Mencos";
    	$est->ubicacion="Melchor de Mencos, Petén, frontera Belice";
    	$est->save();
    }
}
