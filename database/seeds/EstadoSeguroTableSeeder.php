<?php

use Illuminate\Database\Seeder;
use App\estado_seguro;

class EstadoSeguroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $es=new estado_seguro();
    	$es->estado_seguro="Por Cobrar";
    	$es->save();

    	$es=new estado_seguro();
    	$es->estado_seguro="Cobrado";
    	$es->save();
    }
}
