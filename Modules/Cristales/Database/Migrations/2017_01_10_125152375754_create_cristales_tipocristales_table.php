<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCristalesTipoCristalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cristales__tipocristales', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre',60);
            $table->string('codigo',30)->unique();

            $table->integer('categoria_cristal_id')->unsigned()->index();
            $table->foreign('categoria_cristal_id')->references('id')->on('cristales__categoriacristales')->onDelete('cascade');

            $table->integer('cristal_id')->unsigned()->index();
            $table->foreign('cristal_id')->references('id')->on('cristales__cristales')->onDelete('cascade');

            $table->string('descripcion',255);
            $table->bigInteger('precio_costo');
            $table->bigInteger('precio_venta');
            $table->boolean('activo');
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
		Schema::drop('cristales__tipocristales');
	}
}
