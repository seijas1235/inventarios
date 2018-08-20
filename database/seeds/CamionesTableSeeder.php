<?php

use Illuminate\Database\Seeder;
use App\Camion;

class CamionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cam=new Camion();
    	$cam->nombre="BG-01";
    	$cam->placa="C-000AAA";
    	$cam->observaciones="Asignado a Estación de Servicio de Esquipulas, Chiquimula";
    	$cam->save();

    	$cam=new Camion();
    	$cam->nombre="BG-02";
    	$cam->placa="C-000AAA";
    	$cam->observaciones="Asignado a Estación de Servicio de Sanarate, El Progreso";
    	$cam->save();

    	$cam=new Camion();
    	$cam->nombre="BG-03";
    	$cam->placa="C-000AAA";
    	$cam->observaciones="Asignado a Estación de Servicio de Teculután, Zacapa";
    	$cam->save();
    }
}
