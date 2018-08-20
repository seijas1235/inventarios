<?php

use Illuminate\Database\Seeder;
use App\Destino;

class DestinosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $des=new Destino();
    	$des->nombre="Estación de Servicio Puma, El Mirador, Esquipulas, Chiquimula";
    	$des->contacto="Rolando Padilla";
    	$des->telefonos="55807001";
    	$des->ubicacion="KM 222, Carretera hacia Esquipulas, Esquipulas, Chiquimula";
    	$des->save();

    	$des=new Destino();
    	$des->nombre="Estación de Servicio Puma, Sanarate, El Progreso";
    	$des->contacto="Boris Rodriguez";
    	$des->telefonos="40822465";
    	$des->ubicacion="KM 56.5, Carretera al Atlántico, Esquipulas, Chiquimula";
    	$des->save();

    	$des=new Destino();
    	$des->nombre="Estación de Servicio Puma, Teculután, Zacapa";
    	$des->contacto="Renato Molina";
    	$des->telefonos="30166002";
    	$des->ubicacion="KM 121.5, Carretera al Atlántico, Teculután, Zacapa";
    	$des->save();
    }
}
