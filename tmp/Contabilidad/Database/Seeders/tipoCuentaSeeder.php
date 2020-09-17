<?php namespace Modules\Contabilidad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class tipoCuentaSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $this->call("OthersTableSeeder");
		
		Model::unguard();
		
		DB::table('contabilidad_tipo_cuenta')->insert([
			'id' =>'1',
			'codigo'=> '2',
			'nombre'=> 'activo',
			]);

		DB::table('contabilidad_tipo_cuenta')->insert([
			'id' =>'2',
			'codigo'=> '4',
			'nombre'=> 'pasivo',
			]);

		DB::table('contabilidad_tipo_cuenta')->insert([
			'id' =>'3',
			'codigo'=> '8',
			'nombre'=> 'patrimonio_neto',
			]);

		DB::table('contabilidad_tipo_cuenta')->insert([
			'id' =>'4',
			'codigo'=> '5',
			'nombre'=> 'ingreso',
			]);

		DB::table('contabilidad_tipo_cuenta')->insert([
			'id' =>'5',
			'codigo'=> '3',
			'nombre'=> 'egreso',
			]);

	}

}