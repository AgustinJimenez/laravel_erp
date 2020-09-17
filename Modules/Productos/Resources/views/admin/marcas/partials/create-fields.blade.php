<div class="box-body">
    <p>
        {!! Form::normalInput('codigo', 'Codigo', $errors) !!}
        {!! Form::normalInput('nombre', 'Nombre', $errors) !!}
		{!! Form::normalTextarea('descripcion', 'Descripcion', $errors) !!}
    </p>
</div>
