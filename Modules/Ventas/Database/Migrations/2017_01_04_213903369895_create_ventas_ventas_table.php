<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasVentasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas__ventas', function(Blueprint $table) 
            {
			$table->engine = 'InnoDB';
                  
                  $table->increments('id');

                  $table->enum('tipo', ['venta','preventa','otros']);

                  $table->enum('estado', ['preventa', 'terminado']);

                  $table->boolean('anulado');

                  $table->integer('usuario_sistema_id_create')->unsigned()->index();
                  $table->foreign('usuario_sistema_id_create')->references('id')->on('users')->onDelete('cascade');

                  $table->integer('usuario_sistema_id_edit')->unsigned()->index()->nullable();
                  $table->foreign('usuario_sistema_id_edit')->references('id')->on('users')->onDelete('cascade');

                  $table->integer('cliente_id')->unsigned()->index();
                  $table->foreign('cliente_id')->references('id')->on('clientes__clientes')->onDelete('cascade');

                  $table->integer('caja_id')->unsigned()->index();
                  $table->foreign('caja_id')->references('id')->on('caja_cajas')->onDelete('cascade');

                  $table->string('nro_seguimiento',15);

                  $table->date('fecha_venta');

/*OJO IZQ, OJO DER  Y DISTANCIA INTERPUPILAR PERTENECEN A VISION LEJANA*/
                  $table->string('ojo_izq')->nullable();
                  $table->string('ojo_der')->nullable();
                  $table->string('distancia_interpupilar')->nullable();
                  
                  $table->bigInteger('monto_total');

                  $table->bigInteger('descuento_total')->nullable();

                  $table->string('monto_total_letras');

                  $table->bigInteger('grabado_excenta');

                  $table->bigInteger('grabado_5');

                  $table->bigInteger('grabado_10');

                  $table->bigInteger('total_iva_5');

                  $table->bigInteger('total_iva_10');

                  $table->bigInteger('total_iva');

                  $table->string('observacion_venta',1024);

                  $table->bigInteger('entrega')->nullable();

                  $table->bigInteger('pago_final')->nullable();

                  $table->bigInteger('total_pagado')->nullable();

                  $table->integer('descuento_porcentaje')->nullable();

                  //$table->integer('descuento_monto')->nullable();
                  
                  // Your fields
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
		Schema::drop('ventas__ventas');
	}
}
