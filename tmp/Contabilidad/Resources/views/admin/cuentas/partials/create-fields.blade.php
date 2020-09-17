<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors) !!}

    {!! Form:: normalSelect('tipo', 'Tipo', $errors, $tipos) !!} 

    {!! Form::normalInput('nombre_padre', 'Padre', $errors) !!}

    <input type="text" name="padre" id="padre" style="display: none;">

    {!! Form::normalCheckbox('tiene_hijo', 'Tiene Hijos', $errors) !!}

    {!! Form::normalCheckbox('activo', 'Activo', $errors) !!}

    
</div>
