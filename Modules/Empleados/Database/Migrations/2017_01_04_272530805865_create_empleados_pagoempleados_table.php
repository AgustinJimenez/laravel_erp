<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosPagoEmpleadosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleados__pagoempleados', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('salario');
            $table->boolean('anulado');
            $table->bigInteger('monto_ips');
            $table->bigInteger('extra');
            $table->bigInteger('total');
            $table->date('fecha');
            $table->string('observacion');

            $table->integer('empleado_id')->unsigned()->index();
            $table->foreign('empleado_id')->references('id')->on('empleados__empleados')->onDelete('cascade');

            $table->integer('usuario_sistema_id')->unsigned()->index();
            $table->foreign('usuario_sistema_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('empleados__pagoempleados');
	}
}
