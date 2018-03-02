<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venta_id')->unsigned();
            $table->integer('numero_cuota');
            $table->date('fecha_programada')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('numero_documento');
            $table->float('importe');
            $table->string('pagado_por');
            $table->boolean('estado_pago');
            $table->integer('user_id')->unsigned();
            $table->boolean('activo');

            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade'); 
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
        Schema::dropIfExists('pagos');
    }
}
