	<table>
		<tr>
			<th colspan="5">
				EJERCICIO CONTABLE: {{ $anho_ejercicio }} FECHA DE DOC: {{ $fecha }}
			</th>
		</tr>
	</table>
@if(isset($categorias_productos))
	@foreach ($categorias_productos as $key => $categoria)
		<table>
			<thead>
				<tr>
					<th colspan="5" align="center">
						<b>{{ $categoria->codigo }} - {{ $categoria->nombre }}</b>
					</th>
				</tr>
				<tr>
					<td>
						<strong>Código</strong>
					</td>
					@if($imagen)
						<td>
							<strong>Imagen</strong>
						</td>
					@endif
					<td>
						<strong>Producto</strong>
					</td>
					<td>
						<strong>Stock</strong>
					</td>
					@if($precio_compra)
						<td>
							<strong>Precio Compra</strong>
						</td>
					@endif
					@if($precio_venta)
						<td>
							<strong>Precio Venta</strong>
						</td>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($categoria->producto as $producto)
					<tr>
						<td>
							{{ $producto->codigo }}
						</td>
						@if($imagen)
							@if($producto->getArchivoPath() == '')
							<td></td>
							@else
							<td>
								<img src="{{ $producto->getArchivoPath() }}" style="height: 90px; width: 70px;">
							</td>
							@endif
							
						@endif
							<td>
								{{ $producto->nombre }}
							</td>
							<td>
								{{ $producto->stock }}
							</td>
						@if($precio_compra)

							<td>
								{{ $producto->precio_compra }}
							</td>

						@endif	
						@if($precio_venta)
							<td> 
								{{ $producto->precio_venta }}
							</td>
						@endif			
					</tr>
				@endforeach					   
	        </tbody>
		</table>
	@endforeach
@endif