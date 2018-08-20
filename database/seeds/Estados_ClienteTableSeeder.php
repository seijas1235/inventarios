<?php

use Illuminate\Database\Seeder;
use App\estado_cliente;

class Estados_ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ev=new estado_cliente();
    	$ev->estado_cliente="Activo";
    	$ev->save();

    	$ev=new estado_cliente();
    	$ev->estado_cliente="Inactivo";
    	$ev->save();

    	$ev=new estado_cliente();
    	$ev->estado_cliente="Moroso";
    	$ev->save();

        $ev=new estado_cliente();
        $ev->estado_cliente="Bloqueado";
        $ev->save();
    }
}
