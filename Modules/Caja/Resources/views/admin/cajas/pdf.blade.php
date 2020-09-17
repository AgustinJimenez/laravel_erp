<!DOCTYPE html>
<html>
<head>
	<title>Resumen de la caja del {{ $caja->created_at_format_timestamp }}</title>
	<link rel="stylesheet" type="text/css" href="{{ isset($bootstrap_path)?$bootstrap_path:'' }}"/>
	<style type="text/css">
		.white-cell
		{
			border: 0px solid white!important;
		}
		.cabecera
		{
			font-size:8pt;
		}
		.detalle
		{
			font-size:6pt;
		}
		.venta
		{
			font-size:7pt;
		} 
		.width100
		{
			width: 100%;
		}
		.text-center
		{
			text-align: center;
		}
		.separator
		{
			border-top: 1px solid #8c8b8b;
			border-bottom: 1px solid #fff;
		}
	</style>
</head>
<body>	
	<script type="text/php">
        if ( isset($pdf) ) {
            $x = 72;   $y = 18;    $text = "pagina {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
    <?php $pagos = $caja->pagos;?>
    @if(isset($pagos))
    	<?php $forma_pago_anterior = isset($pagos[0])?$pagos[0]->forma_pago_format:"";?>

		<table class="data-table table table-bordered table-hover width100">

			<thead style=" color:black; ">

				<tr>
					<th colspan="5" class="text-center cabecera"><h4><strong>Apertura de Caja: {{ $caja->created_at_format_timestamp }}@if($caja->cierre_format_timestamp) - Cierre: {{ $caja->cierre_format_timestamp }} @endif</strong></h4></th>
				</tr>

				<tr>
					<th colspan="3" class="text-center cabecera">Usuario: {{ $caja->usuario->last_name.' '.$caja->usuario->first_name }}</th>
					<th colspan="2" class="text-center cabecera">Monto Inicial: {{ $caja->monto_inicial_formateado }}</th>
				</tr>

			</thead>
			<tbody>
				@foreach($caja->pagos_forma_pago() as $key => $pagos)
					@if($pagos)

						<tr><th colspan="5" class="text-center"><strong><p>{{ $pagos[0]->forma_pago_format }}</p></strong></th></tr>

						<tr style="background-color: #DCDCDC;">
							<td colspan="1" class="text-center venta"><strong><p>Nro de Factura:</p></strong></td>
							<td colspan="1" class="text-center venta"><strong><p>Cliente:</p></strong></td>
							<td colspan="1" class="text-center venta"><strong><p>Tipo Factura:</p></strong></td>
							<td colspan="1" class="text-center venta"><strong><p>Total de Factura:</p></strong></td>
							<td colspan="1" class="text-center venta"><strong><p>Total Pagado:</p></strong></td>
						</tr>	
						@foreach($pagos as $key2 => $pago)
							<tr>
				                <td colspan="1" class="text-center detalle">{{ isset($pago->venta->factura)?$pago->venta->factura->nro_factura:'' }}</td>
				                <td colspan="1" class="text-center detalle">{{ isset($pago->venta->cliente)?$pago->venta->cliente->razon_social:'' }}</td>
				                <td colspan="1" class="text-center detalle">{{ isset($pago->venta->factura)?$pago->venta->factura->tipo_factura:'' }}</td>
				                <td colspan="1" class="text-center detalle">{{ isset($pago->venta)?$pago->venta->total_pagado_formateado:'' }}</td>
				                <td colspan="1" class="text-center detalle">{{ isset($pago->venta)?$pago->monto_format:'' }}</td>
				            </tr>
			        	@endforeach

			        		<tr><td colspan="5"></td></tr>	
			        		<tr class="text-center">
				            	<td colspan="4" style="text-align: right;" class="text-center detalle">Total en {{ $pagos[0]->forma_pago_format }}:</td>
								<td colspan="1" class="text-center detalle" style="background-color: #DCDCDC;">
									{{ $pago->caja->get_total_format($pago->forma_pago) }}
								</td>
							</tr>
					@endif
				@endforeach
					<tr><th colspan="5" class="text-center"><strong><p>{{ 'Movimientos' }}</p></strong></th></tr>
	        		<tr style="background-color: #DCDCDC;">
						<td colspan="1" class="text-center venta"><strong><p>Usuario:</p></strong></td>
						<td colspan="1" class="text-center venta"><strong><p>Fecha:</p></strong></td>
						<td colspan="1" class="text-center venta"><strong><p>Tipo:</p></strong></td>
						<td colspan="1" class="text-center venta"><strong><p>Monto:</p></strong></td>
						<td colspan="1" class="text-center venta"><strong><p>Motivo:</p></strong></td>
					</tr>
	        	@foreach($caja->movimientos as $key2 => $movimiento)
	        		<tr>
		                <td colspan="1" class="text-center detalle">{{ $movimiento->usuario }}</td>
		                <td colspan="1" class="text-center detalle">{{ $movimiento->format('fecha_hora','datetime') }}</td>
		                <td colspan="1" class="text-center detalle">{{ $movimiento->tipo }}</td>
		                <td colspan="1" class="text-center detalle">{{ $movimiento->format('monto_fixed','number') }}</td>
		                <td colspan="1" class="text-center detalle" width="86"><p>{{ $movimiento->motivo }}</p></td>
		            </tr>
	        	@endforeach

				    <tr><td colspan="5"></td></tr>
				    <tr><td colspan="5"></td></tr>
				    <tr><td colspan="5"></td></tr>
				    
				    <tr>
				    	<td colspan="4" style="text-align: right;" class="text-center detalle">Monto Inicial:</td>
						<td colspan="1" class="text-center detalle" style="background-color: #DCDCDC;">
							{{ $caja->monto_inicial_formateado }}
						</td>
				    </tr>

				    <tr>
				    	<td colspan="4" style="text-align: right;" class="text-center detalle">Total en Pagos:</td>
						<td colspan="1" class="text-center detalle" style="background-color: #DCDCDC;">
							{{ $caja->total_pagos_format }}
						</td>
				    </tr>

				    <tr>
				    	<td colspan="4" style="text-align: right;" class="text-center detalle">Total en Movimientos:</td>
						<td colspan="1" class="text-center detalle" style="background-color: #DCDCDC;">
							{{ $caja->format('suma_movimientos', 'number') }}
						</td>
				    </tr>

				    
				    <tr><td colspan="5"></td></tr>
				    <tr>	
				    	<td colspan="4" style="text-align: right;" class="text-center detalle">Total:</td>
						<td colspan="1" class="text-center detalle" style="background-color: #DCDCDC;">
							{{ $caja->total_pagos_plus_monto_inicial_plus_movimientos_format }}
						</td>
				    </tr>

			</tbody>
			
		</table>
	@endif
</body>
</html>