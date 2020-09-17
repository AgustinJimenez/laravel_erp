<?php namespace Modules\Contabilidad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class cuentaSeeder extends Seeder {

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
		DB::table('contabilidad__cuentas')->insert([
			'id' =>'1',
			'codigo'=> '2.1',
			'nombre'=> 'Corriente',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  'activo',
			]);

				DB::table('contabilidad__cuentas')->insert([
				'id' =>'4',
				'codigo'=> '2.1.1',
				'nombre'=> 'Disponibilidad',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'10',
					'codigo'=> '2.1.1.01',
					'nombre'=> 'Caja',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'11',
					'codigo'=> '2.1.1.02',
					'nombre'=> 'Recaudaciones A Depositar',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'12',
					'codigo'=> '2.1.1.03',
					'nombre'=> 'Activos De Reserva',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'13',
					'codigo'=> '2.1.1.04',
					'nombre'=> 'Bancos',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'14',
					'codigo'=> '2.1.1.05',
					'nombre'=> 'Cheques Devueltos',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'15',
					'codigo'=> '2.1.1.06',
					'nombre'=> 'Fondos Depositados A Confirmar',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);

					DB::table('contabilidad__cuentas')->insert([
					'id' =>'16',
					'codigo'=> '2.1.1.80',
					'nombre'=> 'Previsiones Acumuladas Bancos',
					'padre'=> 4,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  'activo',
					]);


				DB::table('contabilidad__cuentas')->insert([
				'id' =>'5',
				'codigo'=> '2.1.2',
				'nombre'=> 'Cuentas Por Cobrar - Deudores Presupuestarios -',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);
				DB::table('contabilidad__cuentas')->insert([
				'id' =>'6',
				'codigo'=> '2.1.3',
				'nombre'=> 'Cuentas A Cobrar',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);
				DB::table('contabilidad__cuentas')->insert([
				'id' =>'7',
				'codigo'=> '2.1.4',
				'nombre'=> 'Inversiones De Corto Plazo',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);
				DB::table('contabilidad__cuentas')->insert([
				'id' =>'8',
				'codigo'=> '2.1.5',
				'nombre'=> 'Prestamos',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);
				DB::table('contabilidad__cuentas')->insert([
				'id' =>'9',
				'codigo'=> '2.1.6',
				'nombre'=> 'Existencias',
				'padre'=> 1,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  'activo',
				]);

		DB::table('contabilidad__cuentas')->insert([
			'id' =>'2',
			'codigo'=> '2.2',
			'nombre'=> 'No Corriente',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  'activo',
			]);

		DB::table('contabilidad__cuentas')->insert([
			'id' =>'3',
			'codigo'=> '2.3',
			'nombre'=> 'Permanente',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  'activo',
			]);
		
	}

}