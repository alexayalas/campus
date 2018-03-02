<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ubicacion_id')->unsigned();
            $table->string('lote');
            $table->enum('estado_lote',['disponible','preventa','vendido'])->default('disponible');
            $table->integer('vendedor_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('activo');

            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('vendedor_id')->references('id')->on('vendedores')->onDelete('cascade'); 

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
        Schema::dropIfExists('lotizaciones');
    }
}
