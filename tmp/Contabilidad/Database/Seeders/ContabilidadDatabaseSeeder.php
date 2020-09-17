<?php namespace Modules\Contabilidad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class ContabilidadDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		$this->call(tipoCuentaSeeder::class);

		$this->call(cuentaSeeder::class);


		//http://www.leyes.com.py/todas_disposiciones/2002/decretos/decreto_19771_02-plan-cuentas.pdf
		
	}

}