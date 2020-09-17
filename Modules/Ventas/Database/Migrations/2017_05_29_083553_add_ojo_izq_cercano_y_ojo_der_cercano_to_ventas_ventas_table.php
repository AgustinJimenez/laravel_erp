<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOjoIzqCercanoYOjoDerCercanoToVentasVentasTable extends Migration 
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas__ventas', function(Blueprint $table)
        {
            $table->string('ojo_izq_cercano', 120)->nullable()->after('distancia_interpupilar');
            $table->string('ojo_der_cercano', 120)->nullable()->after('ojo_izq_cercano');
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
            $table->dropColumn('ojo_izq_cercano');
            $table->dropColumn('ojo_der_cercano');
        });
    }

}
