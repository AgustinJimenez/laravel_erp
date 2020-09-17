<div class="box-body">
    
    	<label for="categoria">Categoria</label>
    	<select class="form-control" id="categoria_id" name="categoria_id">
	    	@foreach($categorias as $categoria)
	    		@if($producto->categoria_id==$categoria->id)
	    			<option value={{ $categoria->id }} selected>{{ $categoria->nombre }}</option>
	    		@else
	    			<option value={{ $categoria->id }}>{{ $categoria->nombre }}</option>
	    		@endif
	    		
	    	@endforeach
		</select>

        <br><br>

        <label for="marca">Marca</label>
        <select class="form-control" id="marca_id" name="marca_id">
            @foreach($marcas as $marca)
                @if($producto->marca_id==$marca->id)
                    <option value={{ $marca->id }} selected>{{ $marca->nombre }}</option>
                @else
                     <option value={{ $marca->id }}>{{ $marca->nombre }}</option>
                @endif
            @endforeach
        </select>

        <br><br>

        {!! Form::normalInput('nombre', 'Nombre', $errors, $producto) !!}
        {!! Form::normalInput('codigo', 'Codigo', $errors, $producto) !!}
    @if($permisos->get("Ver Precios de Compra"))
        {!! Form::normalInput('precio_compra_promedio', 'Precio de Compra Promedio', $errors, $producto) !!}
    @else
        <dir style="display:none;">
            {!! Form::normalInput('precio_compra_promedio', 'Precio de Compra Promedio', $errors, $producto) !!}
        </dir>
    @endif
        {!! Form::normalInput('precio_venta', 'Precio de Venta', $errors, $producto) !!}
        {!! Form::normalInput('stock', 'Stock', $errors, $producto, ['readonly'=>'']) !!}
        {!! Form::normalInput('stock_minimo', 'Stock Minimo', $errors, $producto) !!}
        {!! Form::normalInput('fecha_compra', 'Fecha de Compra', $errors, $producto) !!}
        {!! Form::normalCheckbox('activo', 'Activo', $errors, $producto) !!}

        @include('media::admin.fields.file-link', 
        [
	        'entityClass' => 'Modules\\\\Productos\\\\Entities\\\\Producto',
	        'entityId' => $producto->id,
	        'zone' => 'archivo'
      	])

    
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
        @if($permisos->get("Ver Precios de Compra"))
        @endif
            $("#stock").attr('name', 'stock_no_edit');

        	if( $("#stock").val()=='' )
        		$("#stock").val(0);

        	if( $("#stock_minimo").val()=='' )
                $("#stock_minimo").val(0);

            $(window).keydown(function(event)
            {
                if(event.keyCode == 13) 
                {
                  event.preventDefault();
                  $("#fakesubmit").click();
                  return false;
                }
            });

            $("#precio_venta").number( true , 0, '', '.' );

            $("#stock").number( true , 1, ',', '.' );
            $("#stock_minimo").number( true , 1, ',', '.' );
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