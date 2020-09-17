<div class="box-body">
    
    	<label for="categoria">Categoria</label>
    	<select class="form-control" id="categoria_id" name="categoria_id">
	    	@foreach($categorias as $categoria)
	    		<option value={{ $categoria->id }}>{{ $categoria->nombre }}</option>
	    	@endforeach
		</select>
        <br><br>

        <label for="marca">Marca</label>
        <select class="form-control" id="marca_id" name="marca_id">
            @foreach($marcas as $marca)
                <option value={{ $marca->id }}>{{ $marca->nombre }}</option>
            @endforeach
        </select>

        <br><br>

    	{!! Form::normalInput('nombre', 'Nombre', $errors) !!}
        {!! Form::normalInput('codigo', 'Codigo', $errors) !!}
    @if($permisos->get("Ver Precios de Compra"))
        {!! Form::normalInput('precio_compra_promedio', 'Precio de Compra Promedio', $errors) !!}
    @else
        <dir style="display:none;">
            {!! Form::normalInput('precio_compra_promedio', 'Precio de Compra Promedio', $errors) !!}
        </dir>
    @endif
        {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors) !!}
        {!! Form::normalInput('stock', 'Stock', $errors) !!}
        {!! Form::normalInput('stock_minimo', 'Stock Minimo', $errors) !!}
        {!! Form::normalInput('fecha_compra', 'Fecha de Compra', $errors, (object)['fecha_compra' => $fecha_hoy]) !!}
        {!! Form::normalCheckbox('activo', 'Activo', $errors) !!}

        @include('media::admin.fields.new-file-link-single', [
    'zone' => 'archivo'])
    
</div>

{!! Theme::script('js/jquery.number.min.js') !!}
{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

<script type="text/javascript">
        $( document ).ready(function() 
        {
            $('#fecha_compra').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                locale: 'es'
            });

            $("#stock").val(0);

            $("#stock_minimo").val(0);

            $("#activo").prop('checked', true);

            $(window).keydown(function(event)
            {
                if(event.keyCode == 13) {
                  event.preventDefault();
                  $("#fakesubmit").click();
                  return false;
                }
            });

            $("#stock").number( true , 1, ',', '.' );

            $("#stock_minimo").number( true , 1, ',', '.' );

            $("#precio_venta").number( true , 0, '', '.' );
            $("#precio_compra_promedio").number( true , 3, ',', '' );
            $("#fakesubmit").click(function(event)
            {
                if( $("#stock").val()=='' )
                    $("#stock").val(0);

                if( $("#stock_minimo").val()=='' )
                    $("#stock_minimo").val(0);

                $("#precio_venta").number( true , 0, '', '' );

                $("#submit").click();

            });

        });
</script>