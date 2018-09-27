<?php

use Illuminate\Database\Seeder;
use App\MarcaVehiculo;

class MarcasVehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarcaVehiculo::truncate();

        $marca = new MarcaVehiculo;
        $marca->nombre= "Toyota";
        $marca->save();

        $marca = new MarcaVehiculo;
        $marca->nombre= "Honda";
        $marca->save();

        $marca = new MarcaVehiculo;
        $marca->nombre= "Nissan";
        $marca->save();

        $marca = new MarcaVehiculo;
        $marca->nombre= "Hyhundai";
        $marca->save();

        $marca = new MarcaVehiculo;
        $marca->nombre= "Kia";
        $marca->save();
    }
}
