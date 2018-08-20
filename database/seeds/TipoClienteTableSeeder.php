<?php

use Illuminate\Database\Seeder;
use App\Tipo_Cliente;

class TipoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ev=new Tipo_Cliente();
    	$ev->tipo_cliente="Semanal";
        $ev->dias="7";
    	$ev->save();

    	$ev=new Tipo_Cliente();
    	$ev->tipo_cliente="Quincenal";
        $ev->dias="15";
    	$ev->save();

    	$ev=new Tipo_Cliente();
    	$ev->tipo_cliente="Mensual";
        $ev->dias="30";
    	$ev->save();

    	$ev=new Tipo_Cliente();
    	$ev->tipo_cliente="Bimensual";
        $ev->dias="60";
    	$ev->save();

    	$ev=new Tipo_Cliente();
    	$ev->tipo_cliente="Adelantado";
        $ev->dias="0";
    	$ev->save();

    	$ev=new Tipo_Cliente();
    	$ev->tipo_cliente="30 días Calendario";
        $ev->dias="30";
    	$ev->save();
    }
}
