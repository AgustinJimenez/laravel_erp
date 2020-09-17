<div class="box-body">
    <p>
		{!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors, $proveedor) !!}
		{!! Form::normalInput('ruc', 'RUC', $errors, $proveedor) !!}
		{!! Form::normalInput('categoria', 'Categoria', $errors, $proveedor) !!}
		{!! Form::normalInput('direccion', 'Dirección', $errors, $proveedor) !!}
		{!! Form::normalInput('email', 'Email', $errors, $proveedor) !!}
		{!! Form::normalInput('telefono', 'Teléfono', $errors, $proveedor) !!}
		{!! Form::normalInput('celular', 'Celular', $errors, $proveedor) !!}
		{!! Form::normalInput('fax', 'Fax', $errors, $proveedor) !!}
		{!! Form::normalInput('contacto', 'Contacto', $errors, $proveedor) !!}
    </p>
</div>
