<?php

use Illuminate\Database\Seeder;
use App\tipo_inventario_combustible;

class TipoInventarioCombustibleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tic=new tipo_inventario_combustible();
        $tic->tipo_inventario_combustible="Ingreso";
        $tic->save();

        $tic=new tipo_inventario_combustible();
        $tic->tipo_inventario_combustible="Salida";
        $tic->save();

        $tic=new tipo_inventario_combustible();
        $tic->tipo_inventario_combustible="Saldos";
        $tic->save();
    }
}
