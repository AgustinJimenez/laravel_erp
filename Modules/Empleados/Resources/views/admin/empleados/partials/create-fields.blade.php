<div class="box-body">
    <p>
		{!! Form::normalInput('nombre', 'Nombre', $errors) !!}
		{!! Form::normalInput('apellido', 'Apellido', $errors) !!}
		{!! Form::normalInput('cedula', 'Cedula', $errors) !!}
		{!! Form::normalInput('cargo', 'Cargo', $errors) !!}
		{!! Form::normalInput('ruc', 'RUC', $errors) !!}
		{!! Form::normalInput('direccion', 'Dirección', $errors) !!}
		{!! Form::normalInput('email', 'Email', $errors) !!}
		{!! Form::normalInput('telefono', 'Teléfono', $errors) !!}
		{!! Form::normalInput('celular', 'Celular', $errors) !!}
		{!! Form::normalInput('salario', 'Salario', $errors) !!}
		{!! Form::normalCheckbox('ips', 'IPS', $errors) !!}
		{!! Form::normalCheckbox('activo', 'Activo', $errors) !!}
    </p>
</div>
