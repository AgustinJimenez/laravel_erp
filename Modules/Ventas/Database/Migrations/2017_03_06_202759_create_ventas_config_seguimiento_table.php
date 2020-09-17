<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasConfigSeguimientoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_config_seguimiento', function(Blueprint $table)
        {
            $table->increments('id');

            $table->bigInteger('nro_1');

            $table->bigInteger('nro_2');

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
        Schema::drop('ventas_config_seguimiento');
    }

}
