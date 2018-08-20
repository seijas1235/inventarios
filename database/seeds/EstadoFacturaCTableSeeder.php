<?php

use Illuminate\Database\Seeder;
use App\estado_facturac;

class EstadoFacturaCTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $efc=new estado_facturac();
    	$efc->estado_facturac="Creada";
    	$efc->save();

    	$efc=new estado_facturac();
    	$efc->estado_facturac="Eliminada";
    	$efc->save();

    	$efc=new estado_facturac();
    	$efc->estado_facturac="Pagada";
    	$efc->save();

    	$efc=new estado_facturac();
    	$efc->estado_facturac="Refacturada";
    	$efc->save();
    }
}
