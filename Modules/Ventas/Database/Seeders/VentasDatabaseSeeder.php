<?php namespace Modules\Ventas\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ventas\Entities\ConfigSeguimientoVenta;
use DB;

class VentasDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		//$this->call(NroFacturaSeederTableSeeder::class);

		$this->call(VentasFakesDatasSeederTableSeeder::class);
		
		// $this->call("OthersTableSeeder");
	}

}