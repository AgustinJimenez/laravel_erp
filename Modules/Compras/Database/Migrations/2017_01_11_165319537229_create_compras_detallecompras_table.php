<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasDetallecomprasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compras__detallecompras', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('compra_id')->unsigned()->index();
            $table->foreign('compra_id')->references('id')->on('compras__compras')->onDelete('cascade');

            $table->string('descripcion',80);

            $table->integer('producto_id')->unsigned()->index()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos__productos')->onDelete('cascade');

            $table->double('cantidad', 7, 1);
            $table->bigInteger('precio_unitario');
            $table->enum('iva',['10','5','excenta']);
            $table->bigInteger('precio_total');

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
		Schema::drop('compras__detallecompras');
	}
}
