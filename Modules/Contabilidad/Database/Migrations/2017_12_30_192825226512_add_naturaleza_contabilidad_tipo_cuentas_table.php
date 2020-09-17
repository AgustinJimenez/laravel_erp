<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNaturalezaContabilidadTipoCuentasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contabilidad__tipocuentas', function(Blueprint $table)
        {
            $table->string('naturaleza_cuenta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contabilidad__tipocuentas', function(Blueprint $table)
        {
            $table->dropColumn('naturaleza_cuenta');
        }); 
    }

}

