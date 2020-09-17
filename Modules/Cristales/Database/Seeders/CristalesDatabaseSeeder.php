<?php namespace Modules\Cristales\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;

class CristalesDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$faker = Faker::create();	

		$this->call(CristalesCategoriasSeeder::class);

		$this->call(CristalesCristalesSeeder::class);

		$this->call(CristalesTiposSeeder::class);

		$this->call(CristalesDatabaseSeeder::class);

	}

}