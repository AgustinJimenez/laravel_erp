<?php namespace Modules\Contabilidad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class CuentasSeederTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{	

		Model::unguard();
//1
	$activo_id = DB::table('contabilidad__cuentas')->insertGetId([
		
			'codigo'=> '01',
			'nombre'=> 'Activo',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  1,
			'profundidad' =>1,
			]);

		
		$activo_corriente_id = DB::table('contabilidad__cuentas')->insertGetId([
		
			'codigo'=> '01.01',
			'nombre'=> 'Activo Corriente',
			'padre'=> $activo_id,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  1,
			'profundidad' =>2,
			]);

				$disponibilidad_id = DB::table('contabilidad__cuentas')->insertGetId([
		
				'codigo'=> '01.01.01',
				'nombre'=> 'Disponibilidad',
				'padre'=> $activo_corriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.01.01',
					'nombre'=> 'Recaudaciones a Depositar',
					'padre'=> $disponibilidad_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.01.02',
					'nombre'=> 'Caja',
					'padre'=> $disponibilidad_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.01.03',
					'nombre'=> 'Fondos Fijos',
					'padre'=> $disponibilidad_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
		
					'codigo'=> '01.01.01.04',
					'nombre'=> 'Bancos',
					'padre'=> $disponibilidad_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

				$inversiones_temporarias_id = DB::table('contabilidad__cuentas')->insertGetId([
			
				'codigo'=> '01.01.02',
				'nombre'=> 'Inversiones Temporarias',
				'padre'=> $activo_corriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([

					'codigo'=> '01.01.02.01',
					'nombre'=> 'Inversiones Financieras',
					'padre'=> $inversiones_temporarias_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([

					'codigo'=> '01.01.02.02',
					'nombre'=> 'Inversiones en Entidades Vinculadas',
					'padre'=> $inversiones_temporarias_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.02.03',
					'nombre'=> 'Otras Inversiones',
					'padre'=> $inversiones_temporarias_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.02.04',
					'nombre'=> 'Intereses, Regalias y otros Rendimientos de Inversiones',
					'padre'=> $inversiones_temporarias_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

				$Creditos_id = DB::table('contabilidad__cuentas')->insertGetId([
		
				'codigo'=> '01.01.03',
				'nombre'=> 'Creditos',
				'padre'=>$activo_corriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.03.01',
					'nombre'=> 'Deudores por Ventas',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.01.03.02',
					'nombre'=> 'Deudores por Prestamos',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.01.03.03',
					'nombre'=> 'Cuentas a Cobrar a Directores y Funcionarios',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.01.03.04',
					'nombre'=> 'Cuentas a Cobrar a Socios o Entidades Vinculadas',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					$creditos_impuestos_id = DB::table('contabilidad__cuentas')->insertGetId([
	
					'codigo'=> '01.01.03.05',
					'nombre'=> 'Creditos por Impuestos Corrientes',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

						DB::table('contabilidad__cuentas')->insertGetId([
			
						'codigo'=> '01.01.03.05.01',
						'nombre'=> 'Anticipos y Retenciones de Impuesto a la Renta',
						'padre'=> $creditos_impuestos_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
			
						'codigo'=> '01.01.03.05.02',
						'nombre'=> 'Retenciones de IVA',
						'padre'=> $creditos_impuestos_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
				
						'codigo'=> '01.01.03.05.03',
						'nombre'=> 'IVA - Credito Fiscal',
						'padre'=> $creditos_impuestos_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);


					$Anticipos_aProveedores = DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.03.06',
					'nombre'=> 'Anticipos a Proveedores',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

						DB::table('contabilidad__cuentas')->insertGetId([
			
						'codigo'=> '01.01.03.06.01',
						'nombre'=> 'Anticipos a Proveedores Locales',
						'padre'=> $Anticipos_aProveedores,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
			
						'codigo'=> '01.01.03.06.02',
						'nombre'=> 'Anticipos a Proveedores del Exterior',
						'padre'=> $Anticipos_aProveedores,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

					DB::table('contabilidad__cuentas')->insertGetId([
		
					'codigo'=> '01.01.03.99',
					'nombre'=> '(-) PREVISIÓN PARA CRÉDITOS DE DUDOSO COBRO',
					'padre'=> $Creditos_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

				$inventario_id = DB::table('contabilidad__cuentas')->insertGetId([
	
				'codigo'=> '01.01.04',
				'nombre'=> 'Inventarios',
				'padre'=> $activo_corriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);	

					$mercaderias_id = DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.01',
					'nombre'=> 'Mercaderias',
					'padre'=> $inventario_id ,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

						DB::table('contabilidad__cuentas')->insertGetId([

						'codigo'=> '01.01.04.01.01',
						'nombre'=> 'Mercaderias gravadas por el IVA al 10%',
						'padre'=> $mercaderias_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
			
						'codigo'=> '01.01.04.01.02',
						'nombre'=> 'Mercaderias gravadas por el IVA al 5%',
						'padre'=> $mercaderias_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
	
						'codigo'=> '01.01.04.01.03',
						'nombre'=> 'Mercaderias gravadas Exentas de IVA',
						'padre'=> $mercaderias_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  1,
						'profundidad' =>5,
						]);

					DB::table('contabilidad__cuentas')->insertGetId([
		
					'codigo'=> '01.01.04.02',
					'nombre'=> 'Mercaderias Regimen Especiales',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
		
					'codigo'=> '01.01.04.03',
					'nombre'=> 'Productos Terminados',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
		
					'codigo'=> '01.01.04.04',
					'nombre'=> 'Productos en Procesos',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.05',
					'nombre'=> 'Materias Primas',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.06',
					'nombre'=> 'Materiales , Suministros y Repuestos',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.07',
					'nombre'=> 'Productos Agricolas',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.08	',
					'nombre'=> 'Productos Forestales',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.09',
					'nombre'=> 'Activos Biologicos en Produccion',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.10',
					'nombre'=> 'Activos Biologicos en Desarrollo',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>1,
					]);


					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.11',
					'nombre'=> 'Importaciones en Curso',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([

					'codigo'=> '1.01.04.99',
					'nombre'=> '(-) PREVISIÓN POR DEVALUACIÓN DE INVENTARIOS',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.01.04.11',
					'nombre'=> 'Importaciones en Curso',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([

					'codigo'=> '01.01.04.99',
					'nombre'=> '(-) PREVISIÓN POR DEVALUACIÓN DE INVENTARIOS',
					'padre'=> $inventario_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

				$pagados_por_adelantado_id = DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '01.01.05',
				'nombre'=> 'Gastos Pagados por Adelantado',
				'padre'=> $activo_corriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '01.01.05.01',
					'nombre'=> 'Alquileres Pagados por Adelantado',
					'padre'=> $pagados_por_adelantado_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
	
					'codigo'=> '01.01.05.02',
					'nombre'=> 'Seguros Devengar',
					'padre'=> $pagados_por_adelantado_id,
					'tiene_hijo'=> 0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

		$activo_noCorriente_id = DB::table('contabilidad__cuentas')->insertGetId([
		
			'codigo'=> '01.02',
			'nombre'=> 'Activo No Corriente',
			'padre'=> $activo_id,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  1,
			'profundidad' =>2,
			]);


				$cre_largo_plazo_id = DB::table('contabilidad__cuentas')->insertGetId([
	
				'codigo'=> '01.02.01',
				'nombre'=> 'Creditos a largo Plazo',
				'padre'=> $activo_noCorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.01',
					'nombre'=> 'Deudores por Venta',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);


					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.02',
					'nombre'=> 'Deudores por Prestamos',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.03',
					'nombre'=> 'Cuentas a Cobrar a Directores y Funcionarios',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.04',
					'nombre'=> 'Cuentas a Cobrar a socios o entidades Vinculadas',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.05',
					'nombre'=> 'Deudores en Gestion de Cobros - Morosos Similares',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.06',
					'nombre'=> 'Anticipo a Proveedores',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '01.02.01.99',
					'nombre'=> '(-) Prevision para dudoso Cobro',
					'padre'=> $cre_largo_plazo_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

				$prop_plan_equi_id = DB::table('contabilidad__cuentas')->insertGetId([
			
				'codigo'=> '01.02.04',
				'nombre'=> 'Propiedad, Planta y Equipo',
				'padre'=> $activo_noCorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.01',
					'nombre'=> 'Inmueble',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);


					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.02',
					'nombre'=> 'Rodados Transportes',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.03',
					'nombre'=> 'Muebles, Utiles y Enseres',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.04',
					'nombre'=> 'Maquinarias',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.05',
					'nombre'=> 'Equipos',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.06',
					'nombre'=> 'Herramientas',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.07',
					'nombre'=> 'Bienes fuera de Operacion',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.08',
					'nombre'=> 'Mejoras en Predio Ajeno',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.97',
					'nombre'=> 'Bienes Incorporados al Amparo de la Ley N° 60/90',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.98',
					'nombre'=> 'Bienes de arrendamiento Finaciero',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '01.02.04.99',
					'nombre'=> 'Depreciacion Acumulada',
					'padre'=> $prop_plan_equi_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);
					

				$intangibles_id = DB::table('contabilidad__cuentas')->insertGetId([
			
				'codigo'=> '01.02.07',
				'nombre'=> 'Activos Intangibles',
				'padre'=> $activo_noCorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  1,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '01.02.07.01',
					'nombre'=> 'Licencias Marcas y Patentes',
					'padre'=> $intangibles_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '01.02.07.02',
					'nombre'=> 'Franquicias',
					'padre'=> $intangibles_id,
					'tiene_hijo'=>  1,
					'activo'=>  0,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '01.02.07.99',
					'nombre'=> 'Amortizacion Acumulada',
					'padre'=> $intangibles_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);
//2
	$pasivo_id = DB::table('contabilidad__cuentas')->insertGetId([
		
			'codigo'=> '02',
			'nombre'=> 'Pasivo',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  2,
			'profundidad' =>1,
			]);
		
		$pasivo_id_corriente = DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '02.01',
			'nombre'=> 'Pasivo Corriente',
			'padre'=> $pasivo_id,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  2,
			'profundidad' =>2,
			]);

				$pasivo_hijo1_id = DB::table('contabilidad__cuentas')->insertGetId([
				
				'codigo'=> '02.01.01',
				'nombre'=> 'Activo No Corriente',
				'padre'=> $pasivo_id_corriente,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);
					
					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.01.01.01',
					'nombre'=> 'Proveedores Locales',
					'padre'=> $pasivo_hijo1_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '02.01.01.02 ',
					'nombre'=> 'Proveedores del Exterior',
					'padre'=> $pasivo_hijo1_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
			
					'codigo'=> '2.01.01.03 ',
					'nombre'=> 'Intereses a Pagar a Proveedores',
					'padre'=> $pasivo_hijo1_id ,
					'tiene_hijo'=>  0,
					'activo'=>  0,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.01.01.04',
					'nombre'=> 'Otros Acreedores',
					'padre'=> $pasivo_hijo1_id ,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

				$pasivo_hijo2_id = DB::table('contabilidad__cuentas')->insertGetId([
				
				'codigo'=> '02.01.02',
				'nombre'=> 'Deudas Financieras',
				'padre'=> $pasivo_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);
					
					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.02.01',
					'nombre'=> 'Prestamos de bancos y otras Entidades Financieras',
					'padre'=> $pasivo_hijo2_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.02.02',
					'nombre'=> 'Prestamos del dueño, Socios o Entidades Vinculadas',
					'padre'=> $pasivo_hijo2_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.02.03',
					'nombre'=> 'Arrendamientos Finacieros',
					'padre'=> $pasivo_hijo2_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  1,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.02.04',
					'nombre'=> 'Otros Prestamos a Pagar',
					'padre'=> $pasivo_hijo2_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.02.05',
					'nombre'=> 'Intereses a Pagar',
					'padre'=> $pasivo_hijo2_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

				$pasivo_hijo3_id = DB::table('contabilidad__cuentas')->insertGetId([
				
				'codigo'=> '02.01.03',
				'nombre'=> 'Otras Cuentas por Pagar',
				'padre'=> $pasivo_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

					$deudas_fiscales_id = DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.03.01',
					'nombre'=> 'Deudas Fiscales Corrientes',
					'padre'=> $pasivo_hijo3_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

						DB::table('contabilidad__cuentas')->insertGetId([
						'codigo'=> '02.01.03.01.01',
						'nombre'=> 'Impuesto a la renta a Pagar',
						'padre'=> $deudas_fiscales_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  2,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
						'codigo'=> '02.01.03.01.02',
						'nombre'=> 'IVA a Pagar',
						'padre'=> $deudas_fiscales_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  2,
						'profundidad' =>5,
						]);

						DB::table('contabilidad__cuentas')->insertGetId([
						'codigo'=> '02.01.03.01.03',
						'nombre'=> 'Retenciones de Impuestos a Ingresar',
						'padre'=> $deudas_fiscales_id,
						'tiene_hijo'=>  0,
						'activo'=>  1,
						'tipo'=>  2,
						'profundidad' =>5,
						]);

					$deudas_fiscales_id = DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.03.02',
					'nombre'=> 'Obligaciones Laborales Y Cargas Sociales',
					'padre'=> $pasivo_hijo3_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '02.01.03.03',
					'nombre'=> 'Dividendos a Pagar',
					'padre'=> $pasivo_hijo3_id,
					'tiene_hijo'=>  1,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

				$pasivo_hijo4_id = DB::table('contabilidad__cuentas')->insertGetId([
				
				'codigo'=> '02.01.04',
				'nombre'=> 'Provisiones',
				'padre'=> $pasivo_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

				$pasivo_hijo5_id = DB::table('contabilidad__cuentas')->insertGetId([
				
				'codigo'=> '02.01.05',
				'nombre'=> 'Ingresos Diferidos',
				'padre'=> $pasivo_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
				
					'codigo'=> '02.01.05.01',
					'nombre'=> 'Anticipos de Clientes',
					'padre'=> $pasivo_hijo5_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

		$pasivo_nocorriente_id = DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '02.02',
			'nombre'=> 'Pasivo No Corriente',
			'padre'=> $pasivo_id,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  2,
			'profundidad' =>2,
			]);

				$acreedores_largo_plazo_id = DB::table('contabilidad__cuentas')->insertGetId([				
				'codigo'=> '02.02.01',
				'nombre'=> 'Acreedores Comerciales a Largo Palzo',
				'padre'=> $pasivo_nocorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.01.01',
					'nombre'=> 'Proveedores Locales',
					'padre'=> $acreedores_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.01.02',
					'nombre'=> 'Proveedores Exteriores',
					'padre'=> $acreedores_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.01.04',
					'nombre'=> 'Otros Acreedores',
					'padre'=> $acreedores_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

				$deudas_largo_plazo_id = DB::table('contabilidad__cuentas')->insertGetId([				
				'codigo'=> '02.02.02',
				'nombre'=> 'Deudas Financieras a Largo Palzo',
				'padre'=> $pasivo_nocorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.02.01',
					'nombre'=> 'Prestamos de Bancos y otras Entidades Financieras',
					'padre'=> $deudas_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.02.02',
					'nombre'=> 'Prestamos de Socios',
					'padre'=> $deudas_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.02.03',
					'nombre'=> 'Arrendamientos Financieros',
					'padre'=> $deudas_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.02.04',
					'nombre'=> 'Otros Prestamos',
					'padre'=> $deudas_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					
					'codigo'=> '02.02.02.05',
					'nombre'=> 'Intereses a Pagar',
					'padre'=> $deudas_largo_plazo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  2,
					'profundidad' =>4,
					]);

				DB::table('contabilidad__cuentas')->insertGetId([				
				'codigo'=> '02.02.03',
				'nombre'=> 'Otras Cuentas por Pagar',
				'padre'=> $pasivo_nocorriente_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  2,
				'profundidad' =>3,
				]);

//3
	$partrimonio_neto = DB::table('contabilidad__cuentas')->insertGetId([

			'codigo'=> '03',
			'nombre'=> 'Patrimonio Neto',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  3,
			'profundidad' =>1,
			]);

		$capital_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '03.01',
			'nombre'=> 'Capital',
			'padre'=> $partrimonio_neto,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  3,
			'profundidad' =>2,
			]);

				$capital_integrado_id = DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.01.01',
				'nombre'=> 'Capital Integrado',
				'padre'=>$capital_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);
					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '03.01.01.01',
					'nombre'=> 'Capital Suscripto',
					'padre'=>$capital_integrado_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  3,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '03.01.01.02',
					'nombre'=> '(-) CAPITAL A INTEGRAR',
					'padre'=>$capital_integrado_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  3,
					'profundidad' =>4,
					]);

		$reservas_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '03.02',
			'nombre'=> 'Reservas',
			'padre'=> $partrimonio_neto,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  3,
			'profundidad' =>2,
			]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.02.01',
				'nombre'=> 'Reservas Legales',
				'padre'=> $reservas_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);

				$reserva_revaluo_id = DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.02.02',
				'nombre'=> 'Reserva de Revaluo',
				'padre'=> $reservas_id,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '03.02.02.01',
					'nombre'=> 'Reservas Revaluo Fiscal',
					'padre'=> $reserva_revaluo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  3,
					'profundidad' =>4,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '03.02.02.02',
					'nombre'=> 'Reservas Revaluo Tecnico',
					'padre'=> $reserva_revaluo_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  3,
					'profundidad' =>4,
					]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.02.03',
				'nombre'=> 'Otras Reservas',
				'padre'=> $reservas_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);

		$resultado_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '03.03',
			'nombre'=> 'Reservas',
			'padre'=> $partrimonio_neto,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  3,
			'profundidad' =>2,
			]);
				
				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.03.01',
				'nombre'=> 'Resultados Acumulados',
				'padre'=>$resultado_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '03.03.01',
				'nombre'=> 'Resultados del Ejercicio',
				'padre'=>$resultado_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  3,
				'profundidad' =>3,
				]);

//4
	$ingreso = DB::table('contabilidad__cuentas')->insertGetId([

			'codigo'=> '04',
			'nombre'=> 'Ingresos',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>1,
			]);

		$venta_mercaderia_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '04.01',
			'nombre'=> 'Ventas de Mercaderias',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '04.01.01',
				'nombre'=> 'Ventas de Mercaderias Gravadas por el IVA',
				'padre'=> $venta_mercaderia_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>3,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '04.01.02',
				'nombre'=> 'Ventas de Mercaderias Exentas del IVA',
				'padre'=> $venta_mercaderia_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>3,
				]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.02',
			'nombre'=> 'Ventas de Productos Agricolas',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.03',
			'nombre'=> 'Ventas de Ganados',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.04',
			'nombre'=> 'Ventas de Productos Fruticolas y Horticolas',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.05',
			'nombre'=> 'Ventas de Productos de la Explotacion Forestal',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.06',
			'nombre'=> 'Exportaciones de Productos Agricolas Exportados',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.07',
			'nombre'=> 'Exportaciones de Bienes Industrializados',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.08',
			'nombre'=> 'Exportaciones de otros Productos',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.09',
			'nombre'=> 'Ventas de Servicios Gravados',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.10',
			'nombre'=> 'Ventas de Bienes - Regimenes Especiales',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

			DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '4.11',
			'nombre'=> 'Otras Ventas Exentas del IVA',
			'padre'=> $ingreso,
			'tiene_hijo'=>  0,
			'activo'=>  0,
			'tipo'=>  4,
			'profundidad' =>2,
			]);


		$descuentos_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '04.98',
			'nombre'=> '(-) DESCUENTOS CONCEDIDOS',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>2,
			]);

		$devoluciones_id= DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '04.99',
			'nombre'=> '(-) DEVOLUCIONES',
			'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>2,
			]);
//5

	$egreso = DB::table('contabilidad__cuentas')->insertGetId([

			'codigo'=> '05',
			'nombre'=> 'Egresos',
			'padre'=> null,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>1,
			]);

		$costo_mercaderia_id =DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '05.01',
			'nombre'=> 'Costos de Mercaderias',
			'padre'=> $egreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '05.01.01',
				'nombre'=> 'Costos de Mercaderias Gravadas por el IVA',
				'padre'=> $costo_mercaderia_id ,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>3,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '05.01.02',
				'nombre'=> 'Costos de Mercaderias Exentas del IVA',
				'padre'=> $costo_mercaderia_id ,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>3,
				]);

//8			
		$otros_ingresos = DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '08',
			'nombre'=> 'Otros Ingresos',
			//'padre'=> $ingreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>1,
			]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '08.02',
				'nombre'=> 'Intereses Ganados',
				'padre'=> $otros_ingresos,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>2,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '08.03',
				'nombre'=> 'Descuentos Obtenidos',
				'padre'=> $otros_ingresos,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>2,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '08.04',
				'nombre'=> 'Subvenciones',
				'padre'=> $otros_ingresos,
				'tiene_hijo'=>  0,
				'activo'=>  0,
				'tipo'=>  4,
				'profundidad' =>2,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '08.05',
				'nombre'=> 'Resultado por Diferencia de Cambio',
				'padre'=> $otros_ingresos,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>2,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '08.06',
				'nombre'=> 'Ingresos Extraordinarios',
				'padre'=> $otros_ingresos,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  4,
				'profundidad' =>2,
				]);

//10

		$gasto_ventas_comercializacion_id = DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '08',
			'nombre'=> 'Otros Ingresos',
			//'padre'=> $egreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  4,
			'profundidad' =>1,
			]);

			$sueldos_remuneracion_id = DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '10.01',
				'nombre'=> 'Sueldos y otras Remuneraciones al Personal',
				'padre'=> $gasto_ventas_comercializacion_id ,
				'tiene_hijo'=>  1,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>2,
				]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '10.01.01',
					'nombre'=> 'Sueldos y Jornales',
					'padre'=> $sueldos_remuneracion_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  5,
					'profundidad' =>3,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '10.01.02',
					'nombre'=> 'Aporte Patronal',
					'padre'=> $sueldos_remuneracion_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  5,
					'profundidad' =>3,
					]);

					DB::table('contabilidad__cuentas')->insertGetId([
					'codigo'=> '10.01.03',
					'nombre'=> 'Otros Beneficios al Personal',
					'padre'=> $sueldos_remuneracion_id,
					'tiene_hijo'=>  0,
					'activo'=>  1,
					'tipo'=>  5,
					'profundidad' =>3,
					]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '10.02',
			'nombre'=> 'Comisiones Pagadas Sobre venta',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '10.03',
			'nombre'=> 'Viatico de Vendedores',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '10.04',
			'nombre'=> 'Publicidad y Propaganda',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '10.05',
			'nombre'=> 'Fletes Pagados',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '10.99',
			'nombre'=> 'Otros Gastos de Ventas',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

//11
		$gastos_remuneraciones_id = DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.01',
			'nombre'=> 'Gastos y otras Remuneraciones al Personal',
			'padre'=> $egreso,
			'tiene_hijo'=>  1,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '11.01.01',
				'nombre'=> 'Sueldos y Jornales',
				'padre'=> $gastos_remuneraciones_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>3,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '11.01.02',
				'nombre'=> 'Aporte Patronal',
				'padre'=> $gastos_remuneraciones_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>3,
				]);

				DB::table('contabilidad__cuentas')->insertGetId([
				'codigo'=> '11.01.03',
				'nombre'=> 'Otros Beneficios al Personal',
				'padre'=> $gastos_remuneraciones_id,
				'tiene_hijo'=>  0,
				'activo'=>  1,
				'tipo'=>  5,
				'profundidad' =>3,
				]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.02',
			'nombre'=> 'Remuneracion Personal Superior',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.03',
			'nombre'=> 'Gastos de Representacion',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);
	
		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.04',
			'nombre'=> 'Honorarios Profesionales',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.05',
			'nombre'=> 'Alquileres',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.06',
			'nombre'=> 'Agua, Luz, Telefono e Internet',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.07',
			'nombre'=> 'Movilidad',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.08',
			'nombre'=> 'Combustibles y Lubricantes',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.09',
			'nombre'=> 'Reparaciones y Mantenimiento',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.10',
			'nombre'=> 'Seguros Pagados',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.11',
			'nombre'=> 'Gastos No Deducibles',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.12',
			'nombre'=> 'Gastos Pagados en el Exterior',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.13',
			'nombre'=> 'Juicios y gastos Judiciales',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.14',
			'nombre'=> 'Gastos de Cobranza',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.15',
			'nombre'=> 'Donaciones y Contribuciones',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.16',
			'nombre'=> 'Comisiones y gastos Bancarios Operacionales',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.17',
			'nombre'=> 'Impuestos, Patentes, Tasas y otras Contribuciones',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);

		DB::table('contabilidad__cuentas')->insertGetId([
			'codigo'=> '11.18',
			'nombre'=> 'Multas y Sanciones',
			'padre'=> $egreso,
			'tiene_hijo'=>  0,
			'activo'=>  1,
			'tipo'=>  5,
			'profundidad' =>2,
			]);
	}

}	