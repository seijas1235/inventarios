<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(TiposProveedorTableSeeder::class);
        $this->call(TiposTransmisionTableSeeder::class);
        $this->call(PuestosTableSeeder::class);
        $this->call(TiposClienteTableSeeder::class);
        $this->call(ProveedoresTableSeeder::class);
        $this->call(TiposVehiculoTableSeeder::class);
        $this->call(TiposMarcaTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(TiposPagoTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }
}
