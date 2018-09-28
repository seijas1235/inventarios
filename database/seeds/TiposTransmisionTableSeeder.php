<?php

use Illuminate\Database\Seeder;
use App\TipoTransmision;

class TiposTransmisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTransmision::truncate();

        $tt = new TipoTransmision;
        $tt->nombre= "Mecánica";
        $tt->save();

        $tt = new TipoTransmision;
        $tt->nombre= "Automática";
        $tt->save();
    }
}
