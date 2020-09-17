<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors, $cuenta) !!}

    {!! Form::normalInput('nombre_padre', 'Padre', $errors) !!}

    <input type="text" class="form-control" name="padre" value="{{ $cuenta->padre }}" style="display: noe;">

    {!! Form::normalCheckbox('tiene_hijo', 'Tiene Hijos', $errors, $cuenta) !!}

    {!! Form::normalCheckbox('activo', 'Activo', $errors, $cuenta) !!}

    {!! Form:: normalSelect('tipo', 'Tipo', $errors, ["activo" => "Activo", "pasivo" => "Pasivo", "patrimonio_neto" => "Patrimonio Neto", "ingreso" => "Ingreso", "egreso" => "Egreso"], $cuenta) !!} 
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#nombre_padre").val('{{ $cuenta->nombre_padre->nombre }}');
	});


</script>