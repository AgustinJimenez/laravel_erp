<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagofacturascreditoPagofacturacreditosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas_pago_factura_credito', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('venta_id')->unsigned()->index();
            $table->foreign('venta_id')->references('id')->on('ventas__ventas')->onDelete('cascade');

            $table->integer('caja_id')->unsigned()->index();
            $table->foreign('caja_id')->references('id')->on('caja_cajas')->onDelete('cascade');

            $table->date('fecha');

            $table->enum('forma_pago', ['efectivo', 'cheque', 'tarjeta_credito', 'tarjeta_debito']);

            $table->bigInteger('monto');

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
		Schema::drop('ventas_pago_factura_credito');
	}
}
