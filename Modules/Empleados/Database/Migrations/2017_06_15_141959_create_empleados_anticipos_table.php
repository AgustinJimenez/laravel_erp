<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosAnticiposTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados__anticipos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->boolean('anulado');

            $table->integer('pago_empleado_id')->unsigned()->index()->nullable();
            $table->foreign('pago_empleado_id')->references('id')->on('empleados__pagoempleados')/*->onDelete('cascade')*/;

            $table->integer('empleado_id')->unsigned()->index();
            $table->foreign('empleado_id')->references('id')->on('empleados__empleados')/*->onDelete('cascade')*/;

            $table->date('fecha');
            $table->bigInteger('monto');
            $table->string('observacion');
            $table->boolean('descontado');
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
        Schema::drop('empleados__anticipos');
    }

}
