<div class="box-body">
    <p>
        {!! Form::normalInput('codigo', 'Codigo', $errors, $marca) !!}
        {!! Form::normalInput('nombre', 'Nombre', $errors, $marca) !!}
		{!! Form::normalTextarea('descripcion', 'Descripcion', $errors, $marca) !!}
    </p>
</div>
