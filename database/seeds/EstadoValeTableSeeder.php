<?php

use Illuminate\Database\Seeder;
use App\estado_vale;

class EstadoValeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ev=new estado_vale();
    	$ev->estado_vale="Creado";
    	$ev->save();

        $ev=new estado_vale();
        $ev->estado_vale="Pago Incompleto";
        $ev->save();

    	$ev=new estado_vale();
    	$ev->estado_vale="Pagado";
    	$ev->save();

    	$ev=new estado_vale();
    	$ev->estado_vale="Anulado";
    	$ev->save();

    	$ev=new estado_vale();
    	$ev->estado_vale="Vencido";
    	$ev->save();
    }
}
