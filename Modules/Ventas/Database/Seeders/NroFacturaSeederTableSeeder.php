<?php namespace Modules\Ventas\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NroFacturaSeederTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		DB::table('ventas_config_factura')->insert([
			'id'=>'1',
			'identificador'=>'nro_factura_1',
			'nombre'=>'factura_inicio',
			'valor'=>'001'
			]);

		DB::table('ventas_config_factura')->insert([
			'id'=>'2',
			'identificador'=>'nro_factura_2',
			'nombre'=>'factura_medio',
			'valor'=>'001'
			]);

		DB::table('ventas_config_factura')->insert([
			'id'=>'3',
			'identificador'=>'nro_factura_3',
			'nombre'=>'factura_final',
			'valor'=>'001'
			]);

		ConfigSeguimientoVenta::create
            ([
                'nro_1' => intval( date('y') ),
                'nro_2' => 1
            ]);
	}

}