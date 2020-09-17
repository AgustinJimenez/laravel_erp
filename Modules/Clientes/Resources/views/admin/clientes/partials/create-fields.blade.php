<div class="box-body">
    <p>
		{!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors) !!}
		{!! Form::normalInput('cedula', 'Cedula', $errors) !!}
		{!! Form::normalInput('ruc', 'RUC', $errors) !!}
		{!! Form::normalInput('direccion', 'Localidad', $errors) !!}
		{!! Form::normalInput('email', 'Email', $errors) !!}
		{!! Form::normalInput('telefono', 'Teléfono', $errors) !!}
		{!! Form::normalInput('celular', 'Celular', $errors) !!}
		{!! Form::normalCheckbox('activo', 'Activo', $errors) !!}
    </p>
</div>
