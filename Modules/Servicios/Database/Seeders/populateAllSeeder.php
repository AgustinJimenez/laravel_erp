<?php namespace Modules\Servicios\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;

class populateAllSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//composer require fzaninotto/faker
		
		// $this->call("OthersTableSeeder");
		
		Model::unguard();
		
		$faker = Faker::create();

		for ($i=0; $i < 5000; $i++) 
		{
			DB::table('servicios__servicios')->insert([
			'nombre'=> $faker->unique()->catchPhrase,
			'codigo'=> $faker->unique()->iban($countryCode=null),
			'descripcion' => $faker->realText($maxNbChars = 200, $indexSize = 2) ,
			'precio_venta'=> $faker->numberBetween($min = 300000, $max = 900000),
			'activo'=>  $faker->boolean,
			]);
		}
	}

}