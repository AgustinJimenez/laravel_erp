<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasFacturasConfigTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_facturas_config', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('nro_factura_1', 30);

            $table->string('nro_factura_2', 30);

            $table->string('nro_factura_ai', 30);

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
        Schema::drop('compras_facturas_config');
    }

}
