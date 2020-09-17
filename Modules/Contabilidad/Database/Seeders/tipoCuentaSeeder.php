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
		
		DB::table('contabilidad__tipocuentas')->insert([
			'id' =>'01',
			'codigo'=> '01',
			'nombre'=> 'Activo',
			'naturaleza_cuenta'=> 'deudor',
			]);

		DB::table('contabilidad__tipocuentas')->insert([
			'id' =>'02',
			'codigo'=> '02',
			'nombre'=> 'Pasivo',
			'naturaleza_cuenta'=> 'acreedor',
			]);

		DB::table('contabilidad__tipocuentas')->insert([
			'id' =>'03',
			'codigo'=> '03',
			'nombre'=> 'Patrimonio Neto',
			'naturaleza_cuenta'=> 'acreedor',
			]);

		DB::table('contabilidad__tipocuentas')->insert([
			'id' =>'04',
			'codigo'=> '04',
			'nombre'=> 'Ingresos',
			'naturaleza_cuenta'=> 'acreedor',
			]);

		DB::table('contabilidad__tipocuentas')->insert([
			'id' =>'05',
			'codigo'=> '05',
			'nombre'=> 'Egresos',
			'naturaleza_cuenta'=> 'deudor',
			]);
		}
	}	