<table>
	<tbody>
	<tr>
		<td>Fecha Inicio: {{ isset($fecha_inicio)?$fecha_inicio:'' }}</td>	
		<td></td>	
		<td>Fecha Fin: {{ isset($fecha_fin)?$fecha_fin:'' }}</td>	
		<td></td>	
		<td>Fecha de Documento: {{ isset($fecha_de_documento)?$fecha_de_documento:'' }}</td>	
		<td></td>
	</tr>
	@foreach($ventas as $key => $venta)
		<tr>
			<th>Nro Factura</th>
			<th>Nro de Sobre</th>		
			<th>Cliente</th>	
			<th>Fecha de Venta</th>	
			<th>Monto Total</th>	
			<th>Total Pagado</th>	
			<th>Ganancia</th>
		</tr>
		<tr>
			<td>{{ ($venta->factura)?$venta->factura->nro_factura:"" }}</td>	
			<td>{{ $venta->nro_seguimiento }}</td>	
			<td>{{ $venta->cliente->razon_social }}</td>	
			<td>{{ $venta->format('fecha_venta', 'date') }}</td>	
			<td>{{ $venta->monto_total }}</td>	
			<td>{{ $venta->total_pagado }}</td>	
			<td>{{ (int)$venta->ganancia_total }}</td>	
		</tr>
		<tr>
			<th>Descripcion</th>	
			<th>Cantidad</th>	
			<th>IVA</th> 
			<th>Costo Unitario</th>	
			<th>Precio Unitario</th>	
			<th>Precio Total</th>
		</tr>
		@foreach($venta->detalles as $key2 => $detalle)
			<tr>
				<td>{{ $detalle->descripcion_producto }}</td>	
				<td>{{ $detalle->cantidad }}</td>	
				<td>{{ $detalle->iva_format }}</td> 
				<td>{{ (int)$detalle->costo_unitario }}</td>	
				<td>{{ $detalle->precio_unitario }}</td>	
				<td>{{ $detalle->precio_total }}</td>
			</tr>
		@endforeach
		<tr>
			<td></td>	
			<td></td>	
			<td></td>	
			<td></td>	
			<td></td>	
			<td></td>
		</tr>
	@endforeach
	</tbody>
</table>

