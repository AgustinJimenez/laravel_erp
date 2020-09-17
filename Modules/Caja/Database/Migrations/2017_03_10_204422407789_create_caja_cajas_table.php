<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaCajasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('caja_cajas', function(Blueprint $table) 
		{
			$table->engine = 'InnoDB';
            $table->increments('id');

            $table->dateTime('cierre');

            $table->integer('usuario_sistema_id')->unsigned()->index();
            $table->foreign('usuario_sistema_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('monto_inicial');

            $table->boolean('activo');
            
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
		Schema::drop('caja_cajas');
	}
}
