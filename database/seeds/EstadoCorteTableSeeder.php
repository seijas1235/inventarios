<?php

use Illuminate\Database\Seeder;
use App\estado_corte;

class EstadoCorteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ec=new estado_corte();
    	$ec->estado_corte="Sin Corte";
    	$ec->save();

    	$ec=new estado_corte();
    	$ec->estado_corte="Corte Diario";
    	$ec->save();

    	$ec=new estado_corte();
    	$ec->estado_corte="Corte Mensual";
    	$ec->save();
    }
}
