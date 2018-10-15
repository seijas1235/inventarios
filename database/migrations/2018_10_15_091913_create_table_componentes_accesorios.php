<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComponentesAccesorios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componentes_accesorios', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('emblemas')->nullable();
            $table->boolean('encendedor')->nullable();
            $table->boolean('espejos')->nullable();
            $table->boolean('antena')->nullable();
            $table->boolean('radio')->nullable();
            $table->boolean('llavero')->nullable();
            $table->boolean('placas')->nullable();
            $table->boolean('platos')->nullable();
            $table->boolean('tapon_combustible')->nullable();
            $table->boolean('soporte_bateria')->nullable();    
            $table->boolean('papeles')->nullable();
            $table->boolean('alfombras')->nullable();
            $table->boolean('control_alarma')->nullable();
            $table->boolean('extinguidor')->nullable();
            $table->boolean('triangulos')->nullable();
            $table->boolean('vidrios_electricos')->nullable();
            $table->boolean('conos')->nullable();
            $table->boolean('neblineras')->nullable();
            $table->boolean('luces')->nullable();
            $table->boolean('llanta_repuesto')->nullable();
            $table->boolean('llave_ruedas')->nullable();
            $table->boolean('tricket')->nullable();
            $table->text('descripcion')->nullable();
            
            $table->unsignedInteger('orden_id')->nullable();
            $table->foreign('orden_id')->references('id')->on('ordenes_de_trabajo')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('componentes_accesorios');
    }
}
