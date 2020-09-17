<div class="box-body">
    <p>
        {!! Form::normalInput('codigo', 'Codigo', $errors, $categoriaproducto) !!}
        {!! Form::normalInput('nombre', 'Nombre', $errors, $categoriaproducto) !!}
		{!! Form::normalTextarea('descripcion', 'Descripcion', $errors, $categoriaproducto) !!}
    </p>
</div>
