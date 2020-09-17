<?php namespace Modules\Contabilidad\Configuracion;
	
	use Modules\Contabilidad\Entities\Cuenta;
	/*
		para usar
		\CuentasFijas::get('pagoempleado.debe.abc')
	*/
		
	class CuentasFijas
	{
		private static $cuentas  = 
		[
			'caja_padre' => '01.01.01.02',
			/*===========PAGO EMPLEADO -store-==============*/
			'pagoempleado.sueldojornales.debe' => '11.01.01',					//SUELDOS Y JORNALES
			'pagoempleado.aportepatronal.debe' => '11.01.02',					//APORTE PATRONAL
			'pagoempleado.ips.debe' => '11.10',									//IPS o seguros pagados
			'pagoempleado.aporte_patronal_ips.haber' => '02.01.03.02',			//IPS Y APORTE PATRONAL A PAGAR o Obligaciones Laborales Y Cargas Sociales
			'pagoempleado.caja.haber' => '01.01.01.02.01',						//caja

			/*===========COMPRA==============*/
			'compra.costo_mercaderia_grabadas_iva' => '05.01.01',				//Costos de Mercaderias Gravadas por el IVA
			'compra.caja' => '01.01.01.02.01',									//caja
			'compra.pago_servicios' => '11.06',									//pago de servicios o Agua, Luz, Telefono e Internet
			'compra.insumos' => '11.11',										//Utiles de Oficina o Gastos No Deducibles
			'compra.iva_credito_fiscal.debe' => '01.01.03.05.03',				//IVA - Credito Fiscal
			'compra.proveedores' => '02.01.01.01',								//Proveedores Locales
			/*===========COMPRA-PAGO==============*/

			//'compra.pago.anticipo_proveedores' => '01.01.03.06.01',			//Anticipos a Proveedores Locales
			'compra.pago.proveedores' => '02.01.01.01',							//Proveedores Locales
			'compra.pago.caja' => '01.01.01.02.01',								//caja

			/*============VENTAS=============*/
			'ventas.ingresos_extraordinarios' => '08.06',												//Ingresos Extraordinarios
			'ventas.caja' => '01.01.01.02.01',															//Caja
			'ventas.deudores_por_venta' => '01.01.03.01',												//Deudores por ventas
			'ventas.preventa.pago_inicial.caja.debe' => '01.01.01.02.01',								//caja
			'ventas.preventa.pago_inicial.anticipos_clientes.haber' => '02.01.05.01',					//Anticipos de Clientes
			'ventas.contado.facturaventa.caja.debe' => '01.01.01.02.01',								//caja
			'ventas.contado.facturaventa.mercaderias_gravadas_iva.haber' => '04.01.01', 				//Ventas de Mercaderias Gravadas por el IVA
			'ventas.contado.facturaventa.iva_credito_fiscal.haber' => '01.01.03.05.03',					//IVA - Credito Fiscal
			'ventas.contado.facturaventa.mercaderias_excentas_iva.haber' => '04.01.02',					//Ventas de Mercaderias Exentas del IVA
			'ventas.otras_ventas.contado.facturaventa.iva_credito_fiscal.haber' => '01.01.03.05.03',	//IVA - Credito Fiscal
			'ventas.credito.facturaventa.deudores_por_venta.debe' => '01.01.03.01',						//Deudores por ventas
			'ventas.credito.facturaventa.mercaderias_gravadas_iva.haber' => '04.01.01',					//Ventas de Mercaderias Gravadas por el IVA
			'ventas.credito.facturaventa.iva_credito_fiscal.haber' => '01.01.03.05.03',					//IVA - Credito Fiscal
			'ventas.credito.facturaventa.mercaderias_excentas_iva.haber' => '04.01.02',					//Ventas de Mercaderias Exentas del IVA
			'ventas.credito.pago.caja.debe' => '01.01.01.02.01',										//Caja
			'ventas.credito.pago.deudores_por_venta.haber' => '01.01.03.01',							//Deudores por ventas
			'ventas.otras_ventas.credito.facturaventa.deudores_por_venta.debe' => '01.01.03.01',		//Deudores por ventas
			'ventas.otras_ventas.credito.facturaventa.iva_credito_fiscal.haber' => '01.01.03.05.03',	//IVA - Credito Fiscal
			'ventas.otras_ventas.credito.pago.caja.debe' => '01.01.01.02.01',							//Caja
			'ventas.otras_ventas.credito.pago.deudores_por_venta.haber' => '01.01.03.01',				//Deudores por ventas
			'ventas.preventa.credito.pago_final.caja.debe' => '01.01.01.02.01',							//caja
			'ventas.preventa.credito.pago_final.anticipos_clientes.haber' => '02.01.05.01',				//Anticipos de Clientes
			'ventas.preventa.contado.facturaventa.caja.debe' => '01.01.01.02.01',						//Caja
			'ventas.preventa.contado.facturaventa.anticipos_clientes.debe' => '02.01.05.01',			//Anticipos de Clientes
			'ventas.preventa.credito.facturaventa.deudores_por_venta.debe' => '01.01.03.01',			//Deudores por ventas
			'ventas.preventa.credito.facturaventa.anticipos_clientes.debe' => '02.01.05.01',			//Anticipos de Clientes
			'ventas.preventa.facturaventa.mercaderias_gravadas_iva.haber' => '04.01.01', 				//Ventas de Mercaderias Gravadas por el IVA
			'ventas.preventa.facturaventa.iva_credito_fiscal.haber' => '01.01.03.05.03', 				//IVA - Credito Fiscal
			'ventas.preventa.facturaventa.mercaderias_excentas_iva.haber' => '04.01.02',				//Ventas de Mercaderias Exentas del IVA

			/*===========Venta-PAGO==============*/
			'ventas.pagos.caja.debe' => '01.01.01.02.01',												//Caja
			'ventas.pagos.deudores_por_venta.haber' => '01.01.03.01',									//Deudores por Ventas
			/*===========FLUJO_EFECTIVO==============*/
			'flujoefectivo.saldo_acumulado.caja' => '01.01.01.02.01',									//CAJA

			/*===========ANTICIPO==============*/
			'empleados.anticipos.anticipo_store.caja' => '01.01.01.02.01',
			"empleados.anticipos.anticipo_store.anticipo_de_salario" => '10.01.04',
			"empleados.pago_empleado.pago_empleado_store.anticipo_de_salario.haber" => '10.01.04',
		];
		
		/*
			para usar \CuentasFijas::get('')->id
			metodo sin parametro retorna array cuentas
			metodo con parametro retorna un objeto tipo entidad cuenta, si es erroneo deberia retornar null o array cuenta
		*/
		public static function get($attribute = null)
		{
			return isset(self::$cuentas[$attribute])?( Cuenta::where('codigo', self::$cuentas[$attribute])->first() ):self::$cuentas;
		}
	}
?>