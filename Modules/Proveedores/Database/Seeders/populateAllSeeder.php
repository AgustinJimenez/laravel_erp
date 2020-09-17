<?php namespace Modules\Proveedores\Database\Seeders;

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

		for ($i=0; $i < 1000; $i++) 
		{
			DB::table('proveedores__proveedors')->insert([
			'razon_social'=> $faker->company,
			'ruc'=> $faker->unique()->numberBetween($min = 1000, $max = 90000),
			'direccion'=>  $faker->address,
			'email'=>  $faker->unique()->email,
			'telefono'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'celular'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'fax'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'contacto'=> $faker->text($maxNbChars = 200) ,
			]);
		}
	}

}