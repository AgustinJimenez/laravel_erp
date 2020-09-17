<div class="box-body">
    <p>
        {!! Form::normalInput('nombre', 'Nombre', $errors, $servicio) !!}
        {!! Form::normalInput('codigo', 'Codigo', $errors, $servicio) !!}
        {!! Form::normalTextarea('descripcion', 'Descripcion', $errors, $servicio) !!}
        {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors, $servicio) !!}
        {!! Form::normalCheckbox('activo', 'Activo', $errors, $servicio) !!}
    </p>
</div>
