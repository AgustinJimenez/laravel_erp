<table>
	<tr>
		<td><b>Fecha Inicio:</b> {{ $fecha_inicio }}</td>
		<td><b>Fecha Fin:</b> {{ $fecha_fin }}</td>
		<td><b>Producto:</b> {{ $producto }}</td>
		<td><b>Categoria:</b> {{ $categoria?$categoria->codigo . " " . $categoria->nombre:"" }}</td>
		<td><b>Marca:</b> {{ $marca?$marca->codigo . " " . $marca->nombre:"" }}</td>
	</tr>
	<tr>
		<th colspan="5"></th>
	</tr>
	<tr>
		<th>CATEGORIA</th>
		<th>MARCA</th>
		<th>PRODUCTO</th>
		<th>TOTAL VENTA</th>
		<th>TOTAL COSTO</th>
		<th>GANANCIA GENERADA</th>
	</tr>
	@foreach ($detalles_ventas as $detalle)
		<tr>
			<td> {{ $detalle->categoria }} </td>
			<td> {{ $detalle->marca }} </td>
			<td> {{ $detalle->producto_nombre }} </td>
			<td>{{ $detalle->total_venta }}</td>
			<td>{{ (int)$detalle->total_costo }}</td>
			<td>{{ (int)$detalle->ganancia }}</td>
		</tr>
	@endforeach
</table>