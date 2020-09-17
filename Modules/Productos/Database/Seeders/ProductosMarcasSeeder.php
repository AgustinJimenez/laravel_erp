<?php namespace Modules\Productos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Modules\Productos\Entities\Marca;
use Faker\Factory as Faker;

class ProductosMarcasSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
		
		Model::unguard();

		for ($i=0; $i < 50; $i++) 
		{	
			Marca::create([
			'codigo'=> $faker->citySuffix.' '.$faker->buildingNumber,
			'nombre'=> $faker->unique()->lastName.' '.$i,
			'descripcion'=> $faker->catchPhrase
			]);
		}
		
	}

}