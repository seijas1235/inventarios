<?php

use Illuminate\Database\Seeder;
use App\unidad_medida;

class UnidadMedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $um=new unidad_medida();
        $um->unidad_medida="Galón";
        $um->save();

        $um=new unidad_medida();
        $um->unidad_medida="Caja";
        $um->save();

        $um=new unidad_medida();
        $um->unidad_medida="Fardo";
        $um->save();
    }
}
