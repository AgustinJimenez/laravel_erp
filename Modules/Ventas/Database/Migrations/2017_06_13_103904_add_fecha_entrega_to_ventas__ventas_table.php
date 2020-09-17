<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaEntregaToVentasVentasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas__ventas', function(Blueprint $table)
        {
            $table->date('fecha_entrega')->nullable()->after('fecha_venta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas__ventas', function(Blueprint $table)
        {
            $table->dropColumn('fecha_entrega');
        });
    }

}
