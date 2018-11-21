<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('
        
        CREATE DEFINER=`root`@`localhost` TRIGGER `kardex` BEFORE INSERT ON `movimientos_productos` FOR EACH ROW BEGIN
        DECLARE existencia float;
        set existencia = (SELECT IF(SUM(mp.existencias) IS NULL,0,SUM(mp.existencias)) AS existencias FROM movimientos_productos mp where mp.producto_id = new.producto_id);
               
        insert into kardex (fecha, producto_id, ingreso, salida, existencia_anterior, saldo, transaccion ) 
        values(new.fecha_ingreso, new.producto_id, new.existencias, 0,existencia, existencia + new.existencias, new.id);
        
        END

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
