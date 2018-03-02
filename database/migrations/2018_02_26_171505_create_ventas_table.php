<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('preventa_id')->unsigned();
            $table->integer('afiliado_id')->unsigned();
            $table->string('kardex');
            $table->string('folio');
            $table->integer('lotizacion_id')->unsigned();
            $table->date('fecha_venta');
            $table->float('costo_total');
            $table->integer('tipo_venta');
            $table->integer('numero_cuotas');
            $table->float('valor_cuotas');
            $table->boolean('eatado_venta');
            $table->text('observaciones');
            $table->integer('user_id')->unsigned();
            $table->boolean('activo');


            $table->foreign('afiliado_id')->references('id')->on('afiliados')->onDelete('cascade');
            $table->foreign('lotizacion_id')->references('id')->on('lotizaciones')->onDelete('cascade');
            $table->foreign('preventa_id')->references('id')->on('preventas')->onDelete('cascade');
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
        Schema::dropIfExists('ventas');
    }
}
