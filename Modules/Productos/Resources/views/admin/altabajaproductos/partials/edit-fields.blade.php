<div class="box-body">
        <input type="text" class="form-control input-sm" name="producto_id" id="producto_id" value="{{ $altabajaproducto->producto_id }}" style="display: none;">

        <br>
        {!! Form::normalTextarea('descripcion', 'Descripcion', $errors, $altabajaproducto) !!}
    <div class="row col-md-12" >

        <div class="col-md-4">
            <label for="marca">Operacion</label>
            <select class="form-control" id="operacion" name="operacion">
            	
            	@if($altabajaproducto->operacion=='alta')
            	{
            		<option value='alta' selected="">Alta(+)</option>
                	<option value='baja'>Baja(-)</option>
                	
            	}
            	@else
            	{
            		<option value='alta' >Alta(+)</option>
                	<option value='baja' selected>Baja(-)</option>
                	

            	}
            	@endif
            </select>
        </div>

        <div class="col-md-4">
            <label for="marca">Cantidad</label>
            <input type="text" class="form-control input-sm" name="cantidad" id="cantidad" value="{{ $altabajaproducto->cantidad }}" style="">
        </div>
        
        <div class="col-md-4">
            {!! Form::normalInput('fecha', 'Fecha', $errors	) !!}
        </div>

        <br>

     </div>

    <input type="text" class="form-control input-sm" name="stockAlter" id="stockAlter" value={{ $anteriorStock }} style="display: none;" >
    <br><br><br>
    <label for="" id="" style="margin-top: 2%;">Stock del producto despues de la operacion: <label for="resultado" id="resultado" style=" color:red;" ></label><label> &nbsp;unidades</label>

 	<label id="now" style="display: none;">{{ $fecha }}</label>
       

    <style type="text/css">
        
        #cke_1_top
        {
            display: none;
        }

        #cke_1_bottom
        {
            display: none;
        }
        .tiny
        {
            width: auto;

            display: inline
        }

    </style>
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    <script type="text/javascript">
    	$( document ).ready(function()
    		{
    			$("#fecha").val( $('#now').text()  );

                $(window).keydown(function(event)
                {
                    if(event.keyCode == 13) {
                      event.preventDefault();
                      $("#fakesubmit").click();
                      return false;
                    }
                });

                $("#fakesubmit").click(function()
                {
                    if( $("#cantidad").val()=='' )
                        $("#cantidad").val(0);
                    

                    $("#submit").click();

                });

    			document.getElementById('resultado').innerHTML = $("#stockAlter").val();

    			$('#fecha').datetimepicker(
	            {
	                format: 'YYYY-MM-DD',
	                locale: 'es'
	            });

	            $('#fecha').val(  );
	            

                $('#operacion').on('change',function()
                {
                    operacion=$(this).val();

                    console.log('cambiado a '+operacion);

                    calculo();
                });

                $('#cantidad').on( "keyup", function()
                {
                    calculo();
                });

                calculo();

                function calculo()
                {
                    operacion = $('#operacion').val();

                    stock = parseInt( {{ $anteriorStock }} );

                    if( $("#cantidad").val()=='' )
                        cantidad = 0;
                    else
                        cantidad = parseInt( $("#cantidad").val() );

                    if(operacion=='alta')
                    {
                        resultado = stock+cantidad;

                        if(resultado<0)
                        {
                           resultado = 0; 
                        }
                    }
                    else
                    {
                        resultado = stock-cantidad;

                        if(resultado<0)
                        {
                            resultado = 0;
                        }
                    }

                    
                    console.log('operacion: '+operacion+' cantidad: '+cantidad+' stock: '+stock+' resultado es: '+resultado);


                    document.getElementById('resultado').innerHTML = resultado;

                    $("#stockAlter").val(resultado);
                }


        

    		});
    </script>
</div>
