            <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasFacturaVentasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas__facturaventas', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('venta_id')->unsigned()->index()->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas__ventas')->onDelete('cascade');
            $table->string('nro_factura', 50);
            $table->date('fecha');
            $table->boolean('anulado');
            $table->enum('tipo_factura', ['contado','credito']);
            $table->integer('usuario_sistema_id_create')->unsigned()->index();
            $table->foreign('usuario_sistema_id_create')->references('id')->on('users')->onDelete('cascade');
            $table->integer('usuario_sistema_id_edit')->unsigned()->index()->nullable();
            $table->foreign('usuario_sistema_id_edit')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('ventas__facturaventas');
	}
}
