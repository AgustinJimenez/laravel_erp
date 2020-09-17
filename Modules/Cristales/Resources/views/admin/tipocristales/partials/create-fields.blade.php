<div class="box-body">
    
    {!! Form::normalInput('codigo', 'Codigo', $errors) !!}

    <div class="form-group">
        <label>Categoria</label>
        <select id="categoria_cristal" name="categoria_cristal_id" class="form-control">
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>


    <label>Cristal</label>
    <div class="form-group">
        <select id="cristal" name="cristal_id" class="form-control">
            @foreach($cristales as $cristal)
                <option value="{{ $cristal->id }}" class="{{ $cristal->categoria->id }}">{{ $cristal->nombre }}</option>
            @endforeach
        </select>
    </div>

    {!! Form::normalInput('nombre', 'Graduacion o Tipo de Cristal', $errors) !!}

    {!! Form::normalInput('descripcion', 'Descripcion', $errors) !!}
@if( $permisos->get("Ver Precios de Compra") )
    {!! Form::normalInput('precio_costo', 'Precio de Costo', $errors) !!}
@endif
    {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors) !!}

    {!! Form:: normalCheckbox('activo', 'Activo',$errors) !!} 


</div>
{!! Theme::script('js/jquery.chained.min.js') !!}
{!! Theme::script('js/jquery.number.min.js') !!}

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#activo").prop('checked',true);

        $("#cristal").chained("#categoria_cristal");
@if( $permisos->get("Ver Precios de Compra") )
        $('#precio_costo').number(true, 0, '', '.');
@endif
        $('#precio_venta').number(true, 0, '', '.');

        $(window).keydown(function(event)
        {
            if(event.keyCode == 13) {
              event.preventDefault();
              $("#fakesubmit").click();
              return false;
            }
        });

        $("#fakesubmit").click(function(event)
        {

            $("#precio_costo").number( true , 0, '', '' );

            $("#precio_venta").number( true , 0, '', '' );

            $("#submit").click();

        });
	});
</script>