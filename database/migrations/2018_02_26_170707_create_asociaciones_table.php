<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsociacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asociaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('ruc',11);
            $table->string('nombre_comercial');
            $table->integer('user_id')->unsigned();
            $table->date('fecha_inicio_labores');
            $table->boolean('activo');

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
        Schema::dropIfExists('asociaciones');
    }
}
