<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('credencial');
            $table->string('apellido_paterno',80);
            $table->string('apellido_materno',80);
            $table->string('nombres',80);
            $table->string('nombre_completo',250);
            $table->string('domicilio');
            $table->string('dni',8);
            $table->string('telefono',7);
            $table->string('celular',9);
            $table->string('email');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_nacimiento');
            $table->integer('ubigeo_id')->unsigned()->nullable();
            $table->string('ocupacion');
            $table->enum('nivel_instruccion',['Primaria','Secundaria','Técnico','Universitario'])->default('Secundaria');
            $table->enum('sexo',['H','M'])->default('H');
            $table->integer('estadocivil_id')->unsigned();
            $table->string('profesion');
            $table->string('foto');
            $table->integer('condicion');
            $table->string('estudios');
            $table->integer('titular_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();            
            $table->boolean('activo');

            $table->foreign('ubigeo_id')->references('id')->on('ubigeos')->onDelete('cascade');
            $table->foreign('estadocivil_id')->references('id')->on('estadosciviles')->onDelete('cascade');
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
        Schema::dropIfExists('afiliados');
    }
}
