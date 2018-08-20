<?php

use Illuminate\Database\Seeder;
use App\estado_producto;

class Estados_ProductoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eprod=new estado_producto();
    	$eprod->estado_producto="Activo";
    	$eprod->save();

    	$eprod=new estado_producto();
    	$eprod->estado_producto="Inactivo";
    	$eprod->save();

    	$eprod=new estado_producto();
    	$eprod->estado_producto="Agotado";
    	$eprod->save();

    	$eprod=new estado_producto();
    	$eprod->estado_producto="Descontinuado";
    	$eprod->save();
    }
}
