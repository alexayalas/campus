<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosExtraordinariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_extraordinarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('afiliado_id')->unsigned();
            $table->integer('tipopagoextraordinario_id')->unsigned();
            $table->date('fecha_pago');
            $table->float('importe');
            $table->integer('user_id')->unsigned();
            $table->string('observaciones');
            $table->boolean('activo');

            $table->foreign('tipopagoextraordinario_id')->references('id')->on('tipo_pagosextraordinarios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 

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
        Schema::dropIfExists('pagos_extraordinarios');
    }
}
