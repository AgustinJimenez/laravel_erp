<?php namespace Modules\Clientes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ClientesDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//composer require fzaninotto/faker
		
		$this->call(populateAllSeeder::class);
		
	}

}