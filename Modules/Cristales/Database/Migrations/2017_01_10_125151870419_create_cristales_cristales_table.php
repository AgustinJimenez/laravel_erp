<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCristalesCristalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cristales__cristales', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre',60);
            $table->integer('categoria_cristal_id')->unsigned()->index();
            $table->foreign('categoria_cristal_id')->references('id')->on('cristales__categoriacristales')->onDelete('cascade');
            
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
		Schema::drop('cristales__cristales');
	}
}
