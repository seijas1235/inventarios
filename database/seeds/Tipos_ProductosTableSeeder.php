<?php

use Illuminate\Database\Seeder;
use App\tipo_producto;

class Tipos_ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tpr=new tipo_producto();
    	$tpr->tipo_producto="Combustibles";
    	$tpr->save();

    	$tpr=new tipo_producto();
    	$tpr->tipo_producto="Aceites y Lubricantes";
    	$tpr->save();

    	$tpr=new tipo_producto();
    	$tpr->tipo_producto="Otros";
    	$tpr->save();

    	$tpr=new tipo_producto();
    	$tpr->tipo_producto="Accesorios";
    	$tpr->save();
    }
}
