<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadCuentasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contabilidad__cuentas', function(Blueprint $table) 
		{
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo',30);
            $table->string('nombre');
            $table->integer('padre')->nullable();
            $table->boolean('tiene_hijo');
            $table->boolean('activo');
            //$table->enum('tipo',['Activo','Pasivo','Patrimonio Neto','Ingreso','Egreso']);
            $table->integer('tipo')->unsigned()->index();
            $table->foreign('tipo')->references('id')->on('contabilidad__tipocuentas')->onDelete('cascade');


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
		Schema::drop('contabilidad__cuentas');
	}
}
