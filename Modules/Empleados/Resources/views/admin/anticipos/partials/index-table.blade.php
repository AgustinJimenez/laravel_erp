<div class="table-responsive">
	<?php $columns = ["Fecha", "Empleado", "Monto", "Descontado", "Anulado", "Acciones"];?>
	<table class="data-table table table-bordered table-hover">
		<thead>
			@foreach($columns as $column)
				<th>{{ $column }}</th>
			@endforeach
		</thead>
		<tbody>
			@if( isset($anticipos) )
				@foreach ($anticipos as $anticipo)
					<tr>
						<td>
							<a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}">
							{{ $anticipo->fecha->format('d/m/Y') }}
							</a>
						</td>
						<td>
							<a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}">
								{{ $anticipo->empleado->nombre_apellido }}
							</a>
						</td>
						<td>
							<a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}">
								{{ $anticipo->monto }}
							</a>
						</td>
						<td>
							<a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}">
								@if($anticipo->descontado) SI @else NO @endif
							</a>
						</td>
						<td>
							<a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}">
								@if($anticipo->anulado) SI @else NO @endif
							</a>
						</td>
						<td>
							<div class="btn-group">
								<!--
                                <a href="{{ route('admin.empleados.anticipos.edit', $anticipo->id) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                -->
                                @if(!$anticipo->anulado and !$anticipo->descontado)
	                                <button class="btn btn-danger btn-flat eliminar-anticipo" descontado="{{ $anticipo->descontado }}" ruta="{{ route('admin.empleados.anticipos.anular', $anticipo->id) }}" >
	                                	<b>ANULAR</b>
	                                </button>
                                @endif
                            </div>
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
		<tfoot>
			@foreach($columns as $column)
				<th>{{ $column }}</th>
			@endforeach
		</tfoot>
	</table>
</div>