<?php namespace Modules\Empleados\Database\Seeders;

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
		
		for ($i=0; $i < 500; $i++) 
		{
			DB::table('empleados__empleados')->insert([
			'nombre'=> $faker->name,
			'apellido'=> $faker->text($maxNbChars = 200) ,
			'cedula'=> $faker->unique()->numberBetween($min = 1000, $max = 90000),
			'cargo' => $faker->jobTitle,
			'ruc'=> $faker->unique()->numberBetween($min = 1000, $max = 90000),
			'direccion'=>  $faker->address,
			'email'=>  $faker->unique()->email,
			'telefono'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'celular'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'salario'=>  $faker->numberBetween($min = 1970000, $max = 6000000),
			'ips'=>  $faker->boolean,
			'activo'=>  $faker->boolean,
			]);
		}
	}

}