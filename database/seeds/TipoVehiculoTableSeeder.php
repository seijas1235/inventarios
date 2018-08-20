<?php

use Illuminate\Database\Seeder;
use App\tipo_vehiculo;

class TipoVehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tv=new tipo_vehiculo();
        $tv->tipo_vehiculo="N/A";
        $tv->user_id=1;
        $tv->save();

        $tv=new tipo_vehiculo();
    	$tv->tipo_vehiculo="Vehículo Sedan";
        $tv->user_id=1;
    	$tv->save();

    	$tv=new tipo_vehiculo();
    	$tv->tipo_vehiculo="Pick-up";
        $tv->user_id=1;
    	$tv->save();

    	$tv=new tipo_vehiculo();
    	$tv->tipo_vehiculo="Camioneta Agrícola";
        $tv->user_id=1;
    	$tv->save();

    	$tv=new tipo_vehiculo();
    	$tv->tipo_vehiculo="Panel";
        $tv->user_id=1;
    	$tv->save();

    	$tv=new tipo_vehiculo();
    	$tv->tipo_vehiculo="Jeep";
        $tv->user_id=1;
    	$tv->save();
    }
}
