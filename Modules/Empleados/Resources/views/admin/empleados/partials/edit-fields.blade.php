<div class="box-body">
    <p>
		{!! Form::normalInput('nombre', 'Nombre', $errors, $empleado) !!}
		{!! Form::normalInput('apellido', 'Apellido', $errors, $empleado) !!}
		{!! Form::normalInput('cedula', 'Cedula', $errors, $empleado) !!}
		{!! Form::normalInput('cargo', 'Cargo', $errors, $empleado) !!}
		{!! Form::normalInput('ruc', 'RUC', $errors, $empleado) !!}
		{!! Form::normalInput('direccion', 'Dirección', $errors, $empleado) !!}
		{!! Form::normalInput('email', 'Email', $errors, $empleado) !!}
		{!! Form::normalInput('telefono', 'Teléfono', $errors, $empleado) !!}
		{!! Form::normalInput('celular', 'Celular', $errors, $empleado) !!}
		{!! Form::normalInput('salario', 'Salario', $errors, $empleado) !!}
		{!! Form::normalCheckbox('ips', 'IPS', $errors, $empleado) !!}
		{!! Form::normalCheckbox('activo', 'Activo', $errors, $empleado) !!}
    </p>
</div>
