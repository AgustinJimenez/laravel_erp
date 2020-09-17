<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCristalesCategoriaCristalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cristales__categoriacristales', function(Blueprint $table) 
		{
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre',60)->unique();
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
		Schema::drop('cristales__categoriacristales');
	}
}
