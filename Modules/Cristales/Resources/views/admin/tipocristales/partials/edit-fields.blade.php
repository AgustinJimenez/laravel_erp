<div class="box-body">

	{!! Form::normalInput('codigo', 'Codigo', $errors, $tipocristales) !!}

    <div class="form-group">
        <label>Categoria</label>
        <select id="categoria_cristal" name="categoria_cristal_id" class="form-control">
            @foreach($categorias as $categoria)
            	@if($tipocristales->categoria_cristal_id == $categoria->id)
                	<option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
                @else
                	<option value="{{ $categoria->id }}" >{{ $categoria->nombre }}</option>
                @endif
            @endforeach
        </select>
    </div>



    <div class="form-group">
        <label>Cristal</label>
        <select id="cristal" name="cristal_id" class="form-control">
            @foreach($cristales as $cristal)
            	@if($tipocristales->cristal_id == $cristal->id)
            		<option value="{{ $cristal->id }}" class="{{ $cristal->categoria->id }}" selected="">{{ $cristal->nombre }}</option>
            	@else
                	<option value="{{ $cristal->id }}" class="{{ $cristal->categoria->id }}">{{ $cristal->nombre }}</option>
                @endif
            @endforeach
        </select>
    </div>



    {!! Form::normalInput('nombre', 'Graduacion o Tipo de Cristal', $errors, $tipocristales) !!}

    {!! Form::normalInput('descripcion', 'Descripcion', $errors, $tipocristales) !!}
@if( $permisos->get("Ver Precios de Compra") )
    {!! Form::normalInput('precio_costo', 'Precio de Costo', $errors, $tipocristales) !!}
@endif
    {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors, $tipocristales) !!}

    {!! Form:: normalCheckbox('activo', 'Activo',$errors, $tipocristales) !!} 
</div>
{!! Theme::script('js/jquery.chained.min.js') !!}
{!! Theme::script('js/jquery.number.min.js') !!}
<script type="text/javascript">
	$(document).ready(function()
	{

        $("#cristal").chained("#categoria_cristal");
@if( $permisos->get("Ver Precios de Compra") )
        $('#precio_costo').number(true, 0, '', '.');
@endif
        $('#precio_venta').number(true, 0, '', '.');

        $(window).keydown(function(event)
        {
            if(event.keyCode == 13) 
            {
              event.preventDefault();
              //$("#fakesubmit").click();
              return false;
            }
        });

        $("#fakesubmit").click(function(event)
        {

            $("#precio_costo").number( true , 0, '', '' );

            $("#precio_venta").number( true , 0, '', '' );

            //$("#submit").click();

        });
	});
</script>