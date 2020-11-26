<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_turnos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedInteger('id_servicio');
            $table->bigInteger('cantidad');
            $table->timestamps();
        });

        Schema::create('informes_maquinas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedInteger('id_maquina');
            $table->bigInteger('cantidad');
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
        Schema::dropIfExists('informes_turnos');
        Schema::dropIfExists('informes_maquinas');
    }
}
