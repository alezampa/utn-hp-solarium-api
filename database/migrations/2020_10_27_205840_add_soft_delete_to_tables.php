<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('servicios', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('maquinas', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('insumos', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('personal', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });

        Schema::table('servicios', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });

        Schema::table('maquinas', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });

        Schema::table('insumos', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });

        Schema::table('personal', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });
    }
}
