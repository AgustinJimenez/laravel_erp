<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasConfigFacturaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_config_factura', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('identificador', 30);

            $table->string('nombre', 30);
            
            $table->string('valor', 15);

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
        Schema::drop('ventas_config_factura');
    }

}
