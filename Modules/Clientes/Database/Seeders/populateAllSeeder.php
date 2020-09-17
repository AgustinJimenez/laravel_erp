<?php namespace Modules\Clientes\Database\Seeders;

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

		for ($i=0; $i < 10000; $i++) 
		{
			DB::table('clientes__clientes')->insert([
			'razon_social'=> $faker->name,
			'cedula'=> $faker->unique()->numberBetween($min = 3000000, $max = 6000000),
			'ruc'=> $faker->unique()->numberBetween($min = 1000, $max = 90000),
			'direccion'=>  $faker->address,
			'email'=>  $faker->unique()->email,
			'telefono'=>  $faker->numberBetween($min = 10000, $max = 9000000),
			'celular'=>  $faker->numberBetween($min = 10000, $max = 9000000),
			'activo'=>  $faker->boolean,
			]);
		}
	}

}