<?php namespace Modules\Ventas\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;
use Modules\Cristales\Entities\TipoCristales as Cristal;
use Modules\Productos\Entities\Producto;
use Modules\Servicios\Entities\Servicio;
use Modules\Ventas\Entities\Venta;
use Modules\Ventas\Entities\DetalleVenta;
use Modules\Ventas\Entities\FacturaVenta;
use Modules\Ventas\Entities\ConfigFacturaVenta;
use Modules\Ventas\Entities\ConfigSeguimientoVenta;
use Log;
include( base_path().'/Modules/funciones_varias.php');

class VentasFakesDatasSeederTableSeeder extends Seeder 
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		date_default_timezone_set('America/Asuncion');

		$generator = Faker::create();


		DB::beginTransaction();

		try
		{		
			for ($i=0; $i < 1000; $i++) 
			{
				$nro_seguimiento = ConfigSeguimientoVenta::first();

            	$nro_seguimiento = $nro_seguimiento->nro_1.'/'.$nro_seguimiento->nro_2;

				$venta = Venta::create
				([
					'tipo' => $generator->randomElement( array('venta') ),
					'estado' => $generator->randomElement( array('terminado') ),
					'usuario_sistema_id_create' => 1,
					'usuario_sistema_id_edit' => null,
					'cliente_id' => $generator->numberBetween($min = 10, $max = 10000),
					'caja_id' => 8,
					'nro_seguimiento' => $nro_seguimiento,
					'fecha_venta' => date($format = 'Y-m-d', strtotime(str_replace('-','/', ''.$generator->numberBetween($min = 2010, $max = 2018).'-'.$generator->numberBetween($min = 1, $max = 12).'-'.$generator->numberBetween($min = 1, $max = 28).''))),
					'ojo_izq' => $generator->text,
					'ojo_der' => $generator->text,
					'distancia_interpupilar' => $generator->text,
					'monto_total' => 0,
					'monto_total_letras' => $generator->sentence($nbWords = 6, $variableNbWords = true),
					'grabado_excenta' => 0,
					'grabado_5' => 0,
					'grabado_10' => 0,
					'total_iva_5' => 0,
					'total_iva_10' => 0,
					'total_iva' => 0,
					'observacion_venta' => $generator->sentence($nbWords = 6, $variableNbWords = true),
					'entrega' => $generator->numberBetween($min = 0, $max = 50000),
					'pago_final' => $generator->numberBetween($min = 0, $max = 50000),
					'total_pagado' => $generator->numberBetween($min = 0, $max = 50000),
					'descuento_porcentaje' => null,
					'descuento_monto' => null,
					'anulado' => $generator->numberBetween($min = 0, $max = 0)
				]);

				for ($i2 = 0; $i2 < $generator->numberBetween($min = 1, $max = 10); $i2++) 
				{
					$tipo_eleccion = $generator->numberBetween($min = 1, $max = 3);

					$producto_id = null; $servicio_id = null; $cristal_id = null; $precio_unitario = '0 '; $costo_unitario = '0';

					if($tipo_eleccion == 1)
					{
						$producto = null;

						while(!$producto)
						{ 
							$producto_id =  $generator->numberBetween($min = 1, $max = 78);
							
							$producto = Producto::where('id', $producto_id)->first();
						}

						$precio_unitario = $producto->precio_venta;

						$costo_unitario = $producto->precio_compra;
					}
					else if($tipo_eleccion == 2)
					{
						$servicio = null;

						while(!$servicio)
						{ 
							$servicio_id =  $generator->numberBetween($min = 1, $max = 400);

							$servicio = Servicio::where('id', $servicio_id)->first();
						}

						$precio_unitario = $servicio->precio_venta;
					}
					else if($tipo_eleccion == 3)
					{
						$cristal = null;

						while(!$cristal)
						{ 
							$cristal_id =  $generator->numberBetween($min = 1, $max = 55);

							$cristal = Cristal::where('id', $cristal_id)->first();
						}

						$precio_unitario = $cristal->precio_venta;

						$costo_unitario = $cristal->precio_costo;
					}

					if(!$cristal_id)
						Log::info($venta);

					$precio_unitario = remove_dots($precio_unitario);

					$costo_unitario = remove_dots($costo_unitario);

					Log::info('$precio_unitario= '.$precio_unitario.' $costo_unitario= '.$costo_unitario);

					$detalle = DetalleVenta::create
					([
						'venta_id' => $venta->id,
						'producto_id' => $producto_id,
						'servicio_id' => $servicio_id,
						'cristal_id' => $cristal_id,
						'cantidad' => $cantidad = $generator->numberBetween($min = 1, $max = 8),
						'iva' => $generator->randomElement( array('0','11', '21') ),
						'precio_unitario' => isset($precio_unitario)?$precio_unitario:0,
						'costo_unitario' => isset($costo_unitario)?$costo_unitario:0,
						'precio_total' => ($cantidad*$precio_unitario)
					]);

					$detalles[] = $detalle;
				}

				$total_iva_10 = 0; $total_iva_5 = 0; $grabado_excenta = 0; $total_item_con_iva_10 = 0; $total_item_con_iva_5 = 0; $grabado_5 = 0; $grabado_10 = 0;

		        for ($i=0; $i < count($detalles) ; $i++) 
		        { 
		            $precio_unitario = intval( str_replace('.', '', $detalles[$i]->precio_unitario ) );

		            $cantidad = intval( str_replace('.', '', $detalles[$i]->cantidad ) );

		            if($detalles[$i]->iva == '11')
		            {
		                $total_iva_10 += intval( ($precio_unitario*$cantidad)/11 );

		                $total_item_con_iva_10 += $precio_unitario*$cantidad;
		            }
		            else if($detalles[$i]->iva == '21')
		            {
		                $total_iva_5 += intval( ($precio_unitario*$cantidad)/21 );

		                $total_item_con_iva_5 += $precio_unitario*$cantidad;
		            }
		            else
		            {
		                $grabado_excenta += intval($precio_unitario*$cantidad);
		            }
		        }
		        $grabado_5 = intval($grabado_5);
		        $grabado_10 = intval($grabado_10);

		        $grabado_10 = $total_item_con_iva_10 - $total_iva_10;

		        $grabado_5 = $total_item_con_iva_5 - $total_iva_5;

		        $total_suma = $grabado_excenta + $grabado_5 + $grabado_10 + $total_iva_10 + $total_iva_5;

		        Venta::where('id', $venta->id)
		        ->update
				([
					'grabado_excenta' => $grabado_excenta,
					'grabado_5' => $grabado_5,
					'grabado_10' => $grabado_10,
					'total_iva_5' => $total_iva_5,
					'total_iva_10' => $total_iva_10,
					'total_iva' => ($total_iva_5+$total_iva_10),
					'monto_total' => $venta->calculate_monto_total/*,
					'entrega' => ,
					'pago_final' => ,
					'total_pagado' => 
					*/
				]);



				$nro_factura_ai = (str_pad(ConfigFacturaVenta::where('identificador', 'nro_factura_3')->first()->valor, 3, '0', STR_PAD_LEFT));

				FacturaVenta::create
				([
					'venta_id' => $venta->id,
					'nro_factura' => '001 - 001 - '.$nro_factura_ai.'',
					'fecha' => date($format = 'Y-m-d', strtotime(str_replace('-','/', ''.$generator->numberBetween($min = 2010, $max = 2018).'-'.$generator->numberBetween($min = 1, $max = 12).'-'.$generator->numberBetween($min = 1, $max = 28).''))),
					'tipo_factura' => $generator->randomElement( array('contado','credito') ),
					'usuario_sistema_id_create' => 1
				]);

				ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');

				ConfigSeguimientoVenta::first()->increment('nro_2');

			}
			


		}
        catch (ValidationException $e)
        {
            DB::rollBack();
        }

        DB::commit();

		
	}
}

/*
		
*/










/*

	
  	$UNIDADES = array(
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
  	);
  	$DECENAS = array(
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
  	);
  	$CENTENAS = array(
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
  	);
  	$MONEDAS = array(
    array('country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO COLOMBIANO', 'plural' => 'PESOS COLOMBIANOS', 'symbol', '$'),
    array('country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'DÓLAR', 'plural' => 'DÓLARES', 'symbol', 'US$'),
    array('country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS', 'symbol', '€'),
    array('country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS', 'symbol', '$'),
    array('country' => 'Perú', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES', 'symbol', 'S/'),
    array('country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS', 'symbol', '£'),
    array('country' => 'Argentina', 'currency' => 'ARS', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$'),
    array('country' => 'Paraguay', 'currency' => 'PY', 'singular' => 'GUARANI', 'plural' => 'GUARANIES', 'symbol', 'Gs')
  	);

    $separator = '.';
    $decimal_mark = ',';
    $glue = ' CON ';
    /**
     * Evalua si el número contiene separadores o decimales
     * formatea y ejecuta la función conversora
     * @param $number número a convertir
     * @param $miMoneda clave de la moneda
     * @return string completo
     */
/*
    function to_word($number, $miMoneda = null) 
    {
        if (strpos($number, $this->decimal_mark) === FALSE) 
        {
          $convertedNumber = array(
            $this->convertNumber($number, $miMoneda, 'entero')
          );
        } else {
          $number = explode($this->decimal_mark, str_replace($this->separator, '', trim($number)));
          $convertedNumber = array(
            $this->convertNumber($number[0], $miMoneda, 'entero'),
            $this->convertNumber($number[1], $miMoneda, 'decimal'),
          );
        }
        return implode($this->glue, array_filter($convertedNumber));
    }
    *
     * Convierte número a letras
     * @param $number
     * @param $miMoneda
     * @param $type tipo de dígito (entero/decimal)
     * @return $converted string convertido
     
    function convertNumber($number, $miMoneda = null, $type) 
    {   
        
        $converted = '';
        if ($miMoneda !== null) {
            try {
                
                $moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) 
                {
                    return ($m['currency'] == $miMoneda);
                });
                $moneda = array_values($moneda);
                if (count($moneda) <= 0) {
                    throw new Exception("Tipo de moneda inválido");
                    return;
                }
                ($number < 2 ? $moneda = $moneda[0]['singular'] : $moneda = $moneda[0]['plural']);
            } catch (Exception $e) {
                echo $e->getMessage();
                return;
            }
        }else{
            $moneda = '';
        }
        if (($number < 0) || ($number > 999999999)) {
            return false;
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
            }
        }
        
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', $this->convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }
        $converted .= $moneda;
        return $converted;
    }
    /**
     * Define el tipo de representación decimal (centenas/millares/millones)
     * @param $n
     * @return $output
     */
 /*
    function convertGroup($n) 
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = $this->CENTENAS[$n[0] - 1];   
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= $this->UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            }
        }
    

	}
*/