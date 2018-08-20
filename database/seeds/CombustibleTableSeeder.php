<?php

use Illuminate\Database\Seeder;
use App\combustible;


class CombustibleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$tpr=new combustible();
    	$tpr->combustible="Diesel AutoS.";
    	$tpr->tipo_servicio_id=2;
    	$tpr->save();

    	$tpr=new combustible();
    	$tpr->combustible="Super AutoS.";
    	$tpr->tipo_servicio_id=2;
    	$tpr->save();

    	$tpr=new combustible();
    	$tpr->combustible="Regular AutoS.";
    	$tpr->tipo_servicio_id=2;
    	$tpr->save();

    	$tpr=new combustible();
    	$tpr->combustible="Diesel";
    	$tpr->tipo_servicio_id=1;
    	$tpr->save();

    	$tpr=new combustible();
    	$tpr->combustible="Super";
    	$tpr->tipo_servicio_id=1;
    	$tpr->save();

    	$tpr=new combustible();
    	$tpr->combustible="Regular";
    	$tpr->tipo_servicio_id=1;
    	$tpr->save();

        $tpr=new combustible();
        $tpr->combustible="Lubricantes";
        $tpr->tipo_servicio_id=1;
        $tpr->save();

        $tpr=new combustible();
        $tpr->combustible="Otros";
        $tpr->tipo_servicio_id=1;
        $tpr->save();
    }
}
