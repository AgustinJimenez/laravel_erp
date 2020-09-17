<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadAsientosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contabilidad__asientos', function(Blueprint $table) 
		{
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha');
            $table->string('operacion',60);
            $table->string('observacion',1000);

            $table->integer('usuario_create_id')->unsigned()->index()->nullable();
            $table->foreign('usuario_create_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('usuario_edit_id')->unsigned()->index()->nullable();
            $table->foreign('usuario_edit_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('entidad_id')->nullable();

            $table->string('entidad_type')->nullable();

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
		Schema::drop('contabilidad__asientos');
	}
}
