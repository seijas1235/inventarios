<?php

use Illuminate\Database\Seeder;
use App\meses;

class MesesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mes=new meses();
    	$mes->mes="Enero";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Febrero";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Marzo";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Abril";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Mayo";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Junio";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Julio";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Agosto";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Septiembre";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Octubre";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Noviembre";
    	$mes->save();

    	$mes=new meses();
    	$mes->mes="Diciembre";
    	$mes->save();
    }
}
