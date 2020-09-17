<?php namespace Modules\Contabilidad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contabilidad\Entities\Cuenta;
use DB;
use DateTime,DateInterval;

class AsientoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		Model::unguard();
		
		//Venta Credito
		$asiento_id=1;
		$fecha = new DateTime('2016-01-01');
		$fecha_fin	= new DateTime('2016-12-31');
		$c = 0;	
		$asiento1_cuenta_id= Cuenta::where('nombre','Ventas de Mercaderias Gravadas por el IVA')->lists('id')->first();	
		$asiento2_cuenta_id= Cuenta::where('nombre','Deudores por Ventas')->lists('id')->first();	
		$asiento3_cuenta_id= Cuenta::where('nombre','IVA - Credito Fiscal')->lists('id')->first();	

		while ($fecha != $fecha_fin)
		 {
			for ($i=0; $i <10 ; $i++)
			{ 
				
				$asiento_id = DB::table('contabilidad__asientos')->insertGetId
				([	
					'fecha'=> $fecha,
					'observacion'=> 'Venta Credito'
				]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento1_cuenta_id,
						'debe'=> 0,
						'haber'=>  830720,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento2_cuenta_id,
						'debe'=> 872256,
						'haber'=>  0,
						'observacion'=>  2,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento3_cuenta_id,
						'debe'=> 0,
						'haber'=>  41536,
						'observacion'=>  3,
					]);

					$c++;

					if ($c==10) 
					{
						$fecha->add(new DateInterval('P1D'));
						$c=0;
					}
			
			}
		}
		
		//Cobranza de Venta Credito
		
		
		$fecha = new DateTime('2016-01-01');
		$fecha_fin	= new DateTime('2016-12-31');
		$c = 0;		
		$asiento1_cuenta_id= Cuenta::where('nombre','Caja')->lists('id')->first();
		$asiento2_cuenta_id= Cuenta::where('nombre','Deudores por Ventas')->lists('id')->first();	

		while ($fecha != $fecha_fin)
		 {
			for ($i=0; $i <10 ; $i++)
			{ 
				
				$asiento_id = DB::table('contabilidad__asientos')->insertGetId
				([	
					'fecha'=> $fecha,
					'observacion'=> 'Cobranza de Venta Credito'
				]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento1_cuenta_id,
						'debe'=> 0,
						'haber'=>  830720,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento2_cuenta_id,
						'debe'=> 872256,
						'haber'=>  0,
						'observacion'=>  2,
					]);

					$c++;

					if ($c==10) 
					{
						$fecha->add(new DateInterval('P1D'));
						$c=0;
					}
			
			}
		}

		// // Compra Contado
		$fecha = new DateTime('2016-01-01');
		$fecha_fin	= new DateTime('2016-12-31');
		$c = 0;
		$asiento1_cuenta_id= Cuenta::where('nombre','Costos de Mercaderias Gravadas por el IVA')->lists('id')->first();
		$asiento2_cuenta_id= Cuenta::where('nombre','Caja')->lists('id')->first();
		$asiento3_cuenta_id= Cuenta::where('nombre','IVA - Credito Fiscal')->lists('id')->first();

		while ($fecha != $fecha_fin)
		 {
			for ($i=0; $i <15 ; $i++)
			{ 
				
				$asiento_id = DB::table('contabilidad__asientos')->insertGetId
				([	
					'fecha'=> $fecha,
					'observacion'=> 'Compra Contado'
				]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento1_cuenta_id,
						'debe'=> 158297,
						'haber'=>  0,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento2_cuenta_id,
						'debe'=> 0,
						'haber'=>  174127,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento3_cuenta_id,
						'debe'=> 15830,
						'haber'=>  0,
						'observacion'=>  1,
					]);

					$c++;

					if ($c==15) 
					{
						$fecha->add(new DateInterval('P1D'));
						$c=0;
					}
			
			}
		}
		// //Compra Credito
		$fecha = new DateTime('2016-01-01');
		$fecha_fin	= new DateTime('2016-12-31');
		$c = 0;
		$asiento1_cuenta_id= Cuenta::where('nombre','Proveedores Locales')->lists('id')->first();
		$asiento2_cuenta_id= Cuenta::where('nombre','Costos de Mercaderias Gravadas por el IVA')->lists('id')->first();
		$asiento3_cuenta_id= Cuenta::where('nombre','IVA - Credito Fiscal')->lists('id')->first();	

		while ($fecha != $fecha_fin)
		 {
			for ($i=0; $i <15 ; $i++)
			{ 
				
				$asiento_id = DB::table('contabilidad__asientos')->insertGetId
				([	
					'fecha'=> $fecha,
					'observacion'=> 'Compra Credito'
				]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento1_cuenta_id,
						'debe'=> 0,
						'haber'=>  481500,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento2_cuenta_id,
						'debe'=> 437727,
						'haber'=>  0,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento3_cuenta_id,
						'debe'=> 43773,
						'haber'=>  0,
						'observacion'=>  1,
					]);

					$c++;

					if ($c==15) 
					{
						$fecha->add(new DateInterval('P1D'));
						$c=0;
					}
			
			}
		}
		// //Pago Compra Credito

		$asiento1_cuenta_id= Cuenta::where('nombre','Caja')->lists('id')->first();
		$asiento2_cuenta_id= Cuenta::where('nombre','Anticipos a Proveedores Locales')->lists('id')->first();
		$fecha = new DateTime('2016-01-01');
		$fecha_fin	= new DateTime('2016-12-31');
		$c = 0;

		while ($fecha != $fecha_fin)
		{
			for ($i=0; $i <10 ; $i++)
			{ 
				
				$asiento_id = DB::table('contabilidad__asientos')->insertGetId
				([	
					'fecha'=> $fecha,
					'observacion'=> 'Pago Compra Credito'
				]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento1_cuenta_id,
						'debe'=> 0,
						'haber'=>  151000,
						'observacion'=>  1,
					]);

					DB::table('contabilidad__asientodetalles')->insertGetId
					([
						
						'asiento_id'=> $asiento_id,
						'cuenta_id'=> $asiento2_cuenta_id,
						'debe'=> 151000,
						'haber'=>  0,
						'observacion'=>  1,
					]);

					$c++;

					if ($c==10) 
					{
						$fecha->add(new DateInterval('P1D'));
						$c=0;
					}
			
			}
		}
	}		
}