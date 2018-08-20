<?php

use Illuminate\Database\Seeder;
use App\Banco;

class BancosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bco=new Banco();
        $bco->nombre="N/A";
        $bco->estado_id=1;
        $bco->save();

        $bco=new Banco();
        $bco->nombre="Banrural";
        $bco->estado_id=1;
        $bco->save();

        $bco=new Banco();
        $bco->nombre="Banco Industrial";
        $bco->estado_id=1;
        $bco->save();

        $bco=new Banco();
        $bco->nombre="G&T Continental";
        $bco->estado_id=1;
        $bco->save();

        $bco=new Banco();
        $bco->nombre="Banco Agrícola Mercantil";
        $bco->estado_id=1;
        $bco->save();

        $bco=new Banco();
        $bco->nombre="Banco de los Trabajadores";
        $bco->estado_id=1;
        $bco->save();
    }
}
