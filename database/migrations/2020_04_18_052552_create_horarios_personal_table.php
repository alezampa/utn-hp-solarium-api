<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_personal');
            $table->integer('dia');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios_personal');
    }
}
