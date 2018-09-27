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
        $this->call(MarcasVehiculoTableSeeder::class);
        $this->call(PuestosTableSeeder::class);
        $this->call(TiposClienteTableSeeder::class);
        $this->call(ProveedoresTableSeeder::class);
        $this->call(TiposVehiculoTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }
}
