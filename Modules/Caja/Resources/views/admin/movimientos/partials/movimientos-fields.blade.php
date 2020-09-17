{!! Form::open(['route' => ['admin.caja.caja.store_movimiento'], 'method' => 'post']) !!}

	<div class="col-md-5">
		<!--
		{!! Form::normalInput('fecha_hora', 'Fecha Hora', $errors, isset($movimiento)?$movimiento:null) !!}
		-->
		
			{!! Form::normalInput('monto', 'Monto', $errors, isset($movimiento)?$movimiento:null, ['required' => '']) !!}
		
			{!! Form::normalInput('motivo', 'Motivo', $errors, isset($movimiento)?$movimiento:null, ['required' => '']) !!}	
		
			{!! Form::normalSelect('tipo', 'Tipo de Movimiento', $errors, ['extraccion'=>'Extraccion', 'deposito'=>'Deposito'],isset($movimiento)?$movimiento:null) !!}

			{!! Form::submit('Guardar', array('class' => 'btn btn-primary btn-flat')) !!}
		</div>

		
	</div>

	

{!! Form::close() !!}