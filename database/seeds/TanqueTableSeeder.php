<?php

use Illuminate\Database\Seeder;
use App\tanque;

class TanqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t=new tanque();
    	$t->nombre_tanque="Diesel";
        $t->combustible_id=4;
        $t->capacidad=10000;
    	$t->save();

    	$t=new tanque();
    	$t->nombre_tanque="Super";
        $t->combustible_id=5;
        $t->capacidad=6000;
    	$t->save();

    	$t=new tanque();
    	$t->nombre_tanque="Regular";
        $t->combustible_id=6;
        $t->capacidad=6000;
    	$t->save();
    }
}
