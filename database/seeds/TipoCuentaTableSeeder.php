<?php

use Illuminate\Database\Seeder;
use App\Tipo_Cuenta;

class TipoCuentaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tc=new Tipo_Cuenta();
        $tc->tipo_cuenta="Monetaria";
        $tc->save();

        $tc=new Tipo_Cuenta();
        $tc->tipo_cuenta="Ahorro";
        $tc->save();
    }
}
