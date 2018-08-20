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
        $this->call(TipoClienteTableSeeder::class);
        $this->call(TipoCuentaContableTableSeeder::class);
        $this->call(TipoCuentaTableSeeder::class);
        $this->call(TipoInventarioCombustibleTableSeeder::class);
        $this->call(TipoPagoTableSeeder::class);
        $this->call(Tipos_ProductosTableSeeder::class);
        $this->call(TipoServicioTableSeeder::class);
        $this->call(TipoVehiculoTableSeeder::class);
        $this->call(EstadoChequeTableSeeder::class);
        $this->call(EstadoFleteTableSeeder::class);
        $this->call(EstadoSeguroTableSeeder::class);
        $this->call(EstadoCorteTableSeeder::class);
        $this->call(EstadoFacturaCTableSeeder::class);
        $this->call(EstadoFacturaTableSeeder::class);
        $this->call(EstadoRequisicionTableSeeder::class);
        $this->call(Estados_ClienteTableSeeder::class);
        $this->call(Estados_CuentaCobrarTableSeeder::class);
        $this->call(Estados_EmpleadoTableSeeder::class);
        $this->call(Estados_ProductoTableSeeder::class);
        $this->call(EstadoValeTableSeeder::class);
        $this->call(BancosTableSeeder::class);
        $this->call(BGFactoresTableSeeder::class);
        $this->call(CamionesTableSeeder::class);
        $this->call(Cargos_EmpleadoTableSeeder::class);
        $this->call(CombustibleTableSeeder::class);
        $this->call(DestinosTableSeeder::class);
        $this->call(DocumentosTableSeeder::class);
        $this->call(IDPTableSeeder::class);
        $this->call(MesesTableSeeder::class);
        $this->call(TanqueTableSeeder::class);
        $this->call(BGPagoFleteTableSeeder::class);
        $this->call(Inventario_CombustibleTableSeeder::class);
        $this->call(OperacionBancariaTableSeeder::class);
        $this->call(UnidadMedidaTableSeeder::class);
        $this->call(EstacionServicioTableSeeder::class);
        
    }
}
