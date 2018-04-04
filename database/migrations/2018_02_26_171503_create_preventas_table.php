<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('afiliado_id')->unsigned();
            $table->string('numero_documento');
            $table->float('importe');
            $table->integer('lotizacion_id')->unsigned();
            $table->integer('vendedor_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo');

            $table->foreign('afiliado_id')->references('id')->on('afiliados')->onDelete('cascade');
            $table->foreign('lotizacion_id')->references('id')->on('lotizaciones')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('vendedores')->onDelete('cascade');
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
        Schema::dropIfExists('preventas');
    }
}
