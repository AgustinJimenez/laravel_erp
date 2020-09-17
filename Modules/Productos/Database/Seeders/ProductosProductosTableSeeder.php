<?php namespace Modules\Productos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;

class ProductosProductosTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		$faker = Faker::create();

		for ($i=1; $i < 150; $i++) 
		{
			DB::table('productos__productos')->insert([
			'codigo'=> $faker->unique()->stateAbbr,
			'nombre'=> 'Producto '.$faker->unique()->domainWord ,
			'precio_compra'=> $precio_compra = $faker->numberBetween($min = 50000, $max = 60000),
			'precio_compra_promedio'=> $precio_compra,
			'precio_venta'=> $faker->numberBetween($min = 60000, $max = 80000),
			'fecha_compra' => date($format = 'Y-m-d', strtotime(str_replace('-','/', ''.$faker->numberBetween($min = 2010, $max = 2018).'-'.$faker->numberBetween($min = 1, $max = 12).'-'.$faker->numberBetween($min = 1, $max = 28).''))),
			'stock'=> $faker->numberBetween($min = 10, $max = 200),
			'stock_minimo'=> $faker->numberBetween($min = 1, $max = 10),
			'activo'=> $faker->numberBetween($min = 0, $max = 1),
			'categoria_id'=> $faker->numberBetween($min = 1, $max = 49),
			'marca_id'=> $faker->numberBetween($min = 1, $max = 49),
	
			]);
		}
	}

}