<?php

use Illuminate\Database\Seeder;
use App\tipo_servicio;


class TipoServicioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tpr=new tipo_servicio();
    	$tpr->tipo_servicio="Servicio Completo";
    	$tpr->save();

    	$tpr=new tipo_servicio();
    	$tpr->tipo_servicio="AutoServicio";
    	$tpr->save();
    }
}
