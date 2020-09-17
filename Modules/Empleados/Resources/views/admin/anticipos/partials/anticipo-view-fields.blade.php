<div class="row">
	<div class="col-md-1">
		{!! Form::label('empleado', 'Empleado:') !!}
	</div>
	<div class="col-md-6">
		{{ $anticipo->empleado->nombre_apellido }}
	</div>
</div>

<div class="row">
	<div class="col-md-1">
		{!! Form::label('fecha', 'Fecha:') !!}
	</div>
	<div class="col-md-6">
		{{ $anticipo->fecha->format('d/m/Y') }}
	</div>
</div>

<div class="row">
	<div class="col-md-1">
		{!! Form::label('monto', 'Monto:') !!}
	</div>
	<div class="col-md-6">
		{{ $anticipo->monto }}
	</div>
</div>

<div class="row">
	<div class="col-md-1">
		{!! Form::label('observacion', 'Observacion:') !!}
	</div>
	<div class="col-md-6">
		{{ $anticipo->observacion }}
	</div>
</div>

<div class="row">
	<div class="col-md-6">
	@if($anticipo->descontado)
		<b>Descontado</b>
	@else
		<b>No Descontado</b>
	@endif
	</div>
</div>
<br><br>
<h3>Asientos</h3>
<hr>
<div class="row">
	<div class="col-md-6">
		
		@foreach ($anticipo->asientos as $key => $asiento)
			{!! $asiento->edit_button !!}
		@endforeach
	</div>
</div>

