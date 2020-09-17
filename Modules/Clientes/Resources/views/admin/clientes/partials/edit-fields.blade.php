<div class="box-body">
    <p>
		{!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors, $cliente) !!}
		{!! Form::normalInput('cedula', 'Cedula', $errors, $cliente) !!}
		{!! Form::normalInput('ruc', 'RUC', $errors, $cliente) !!}
		{!! Form::normalInput('direccion', 'Localidad', $errors, $cliente) !!}
		{!! Form::normalInput('email', 'Email', $errors, $cliente) !!}
		{!! Form::normalInput('telefono', 'Teléfono', $errors, $cliente) !!}
		{!! Form::normalInput('celular', 'Celular', $errors, $cliente) !!}
		{!! Form::normalCheckbox('activo', 'Activo', $errors, $cliente) !!}
    </p>
</div>
