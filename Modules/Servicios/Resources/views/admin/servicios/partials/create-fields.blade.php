<div class="box-body">
    <p>
    	{!! Form::normalInput('nombre', 'Nombre', $errors) !!}
        {!! Form::normalInput('codigo', 'Codigo', $errors) !!}
        {!! Form::normalTextarea('descripcion', 'Descripcion', $errors) !!}
        {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors) !!}
        {!! Form::normalCheckbox('activo', 'Activo', $errors) !!}
    </p>
</div>
