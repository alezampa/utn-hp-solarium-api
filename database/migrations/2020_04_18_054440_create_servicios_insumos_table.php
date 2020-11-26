<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_insumos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_insumo');
            $table->unsignedBigInteger('id_servicio');
            $table->integer('cantidad_insumo');

            $table->primary(['id_insumo', 'id_servicio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios_insumos');
    }
}
