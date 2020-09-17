<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadAsientoDetallesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contabilidad__asientodetalles', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('asiento_id')->unsigned()->index();
            $table->foreign('asiento_id')->references('id')->on('contabilidad__asientos')->onDelete('cascade');
            

            $table->integer('cuenta_id')->unsigned()->index();
            $table->foreign('cuenta_id')->references('id')->on('contabilidad__cuentas')->onDelete('cascade');

            $table->bigInteger('debe');

            $table->bigInteger('haber');

            $table->string('observacion', 1000);
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
		Schema::drop('contabilidad__asientodetalles');
	}
}
