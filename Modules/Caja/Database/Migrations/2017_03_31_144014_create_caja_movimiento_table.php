<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaMovimientoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_movimiento', function(Blueprint $table)
        {
            $table->increments('id');

            $table->enum('tipo',['extraccion','deposito']);

            $table->integer('caja_id')->unsigned()->index();
            $table->foreign('caja_id')->references('id')->on('caja_cajas')->onDelete('cascade');

            $table->integer('usuario_sistema_id')->unsigned()->index();
            $table->foreign('usuario_sistema_id')->references('id')->on('users')->onDelete('cascade');

            $table->dateTime('fecha_hora');

            $table->bigInteger('monto');

            $table->string('motivo');

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
        Schema::drop('caja_movimiento');
    }

}
