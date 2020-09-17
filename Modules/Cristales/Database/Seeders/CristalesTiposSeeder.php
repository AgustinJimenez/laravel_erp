<?php namespace Modules\Cristales\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;

class CristalesTiposSeeder extends Seeder {

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
			DB::table('cristales__tipocristales')->insert([
			'nombre'=> 'Cristal '.$faker->unique()->streetName,
			'codigo'=> $faker->unique()->stateAbbr,
			'categoria_cristal_id'=> $faker->numberBetween($min = 1, $max = 3),
			'cristal_id'=> $faker->numberBetween($min = 1, $max = 17),
			'descripcion'=> $faker->catchPhrase,
			'precio_costo' => $faker->numberBetween($min = 40000, $max = 60000),
			'precio_venta'=> $faker->numberBetween($min = 60000, $max = 80000),
			'activo'=> $faker->numberBetween($min = 0, $max = 1)
	
			]);
		}
	}

}