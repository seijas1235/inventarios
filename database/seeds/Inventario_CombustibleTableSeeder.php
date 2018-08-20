<?php

use Illuminate\Database\Seeder;
use App\inventario_combustible;

class Inventario_CombustibleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inv=new inventario_combustible();
        $inv->fecha_inventario=0;
    	$inv->gal_sup_entrada=0;
    	$inv->gal_sup_salida=0;
    	$inv->gal_sup_existencia=0;
    	$inv->precio_promedio_sup=0;
    	$inv->subtotal_entrada_sup=0;
    	$inv->subtotal_salida_sup=0;
    	$inv->subtotal_exis_sup=0;
    	$inv->gal_reg_entrada=0;
    	$inv->gal_reg_salida=0;
    	$inv->gal_reg_existencia=0;
    	$inv->precio_promedio_reg=0;
    	$inv->subtotal_entrada_reg=0;
    	$inv->subtotal_salida_reg=0;
    	$inv->subtotal_exis_reg=0;
    	$inv->gal_die_entrada=0;
    	$inv->gal_die_salida=0;
    	$inv->gal_die_existencia=0;
    	$inv->precio_promedio_die=0;
    	$inv->subtotal_entrada_die=0;
    	$inv->subtotal_salida_die=0;
    	$inv->subtotal_exis_die=0;
    	$inv->user_id=1;
    	$inv->estado=1;
    	$inv->save();
    }
}
