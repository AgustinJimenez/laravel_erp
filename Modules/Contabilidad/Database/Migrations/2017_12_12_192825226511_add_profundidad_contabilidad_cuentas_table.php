<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfundidadContabilidadCuentasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad__cuentas', function(Blueprint $table)
        {
            $table->integer('profundidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad__cuentas', function(Blueprint $table)
        {
            $table->dropColumn('profundidad');
        });
    }

}

