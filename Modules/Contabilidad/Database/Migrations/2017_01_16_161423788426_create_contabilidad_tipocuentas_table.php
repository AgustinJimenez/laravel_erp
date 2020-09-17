<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadTipoCuentasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contabilidad__tipocuentas', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');	

            $table->integer('codigo')->unique();

            $table->string('nombre', 20)->unique();
            
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
		Schema::drop('contabilidad__tipocuentas');
	}
}
