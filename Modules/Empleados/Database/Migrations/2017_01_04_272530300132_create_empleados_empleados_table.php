<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosEmpleadosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleados__empleados', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre',30);
            $table->string('apellido',30);
            $table->string('cedula',10)->unique();
            $table->string('cargo',50);
            $table->string('ruc', 35)->unique();
            $table->string('direccion',50);
            $table->string('email', 30)->unique();
            $table->string('telefono', 20);
            $table->string('celular', 20);
            $table->boolean('activo');
            $table->bigInteger('salario');
            $table->boolean('ips');
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
		Schema::drop('empleados__empleados');
	}
}
