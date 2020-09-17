{!! Theme::script('js/NumeroALetras.js') !!}

{!! Theme::script('js/jquery.number.min.js') !!}	

    {{--{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!} --}}

<script type="text/javascript">
	$(document).ready(function(event)
	{
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});

		setup_inicializar_inputs();

		setup_add_row_with_enter_key();

		setup_global_autocomplete_false();

        calculate_all();

        var row = get_row_from_table();

		$("#agregar").click(function(event)
		{
			add_row();
		});

        $(".eliminar-pago-button").on('click',function(event)
        {
            event.preventDefault();

            var button = $(this);

            var modal_target = button.attr('data-target');

            $(modal_target).modal();

        });


		$('.div_tabla').on('click','.remove_field', function () //si se escribe en cantidad
        {
            remove_row( $(this) );
        });

        $("#actualizar_button").click(function()
        {
            $("#submit").click();
        });
        

        function table_has_zero_rows()
        {
            if( count_rows()>0 )
                return false;
            else
                return true;
        };

		function remove_row(boton)
		{
            var detalle_id = parseInt( boton.closest('td').closest('tr').find('input[id=detalle_id]').val() );

            if(detalle_id)
            {
                boton.closest('td').closest('tr').find('input[id=eliminar]').val(1);

                boton.parent().parent('tr').hide();
            }
            else
            {
                boton.parent().parent('tr').remove();  
            }

            add_row_if_table_has_zero_rows();

            calculate_all();
		};

        function add_row_if_table_has_zero_rows()
        {
            if( table_has_zero_rows() )
            {

                $("#agregar").click();
            }
        };

        function count_rows()
        {
            return $("table > tbody > tr:visible").length;
        };

		function add_row()
		{
			event.preventDefault();
			
			x++;

            $('#tabla_factura').append('<tr id="fila'+x+'" class="fila">'+row+'</tr>');

            $('.precio_unitario').number(true, 0, '', '.');

            $('table > tbody > tr:last').find('input[id=cantidad]').focus();
		}

		$('.div_tabla').on('keyup','.cantidad', function () //si se escribe en cantidad
        {
            calculate_all();
        });

        $('.div_tabla').on('keyup','.precio_unitario', function () //si se escribe en cantidad
        {
            calculate_all();
        });

        $('.div_tabla').on('change','.iva', function () //si se escribe en cantidad
        {
            calculate_all();
        });


		function calculate_all()
        {
            var total = 0;

            var total_sin_iva = 0;

            var total_iva_5 = 0;

            var total_iva_10 = 0;

            var total_ivas = 0;

            $(".fila").each(function() 
            {
                var cantidad = 0;

                var precio_unitario = 0;

                var sub_total = 0;

                var iva = 0;

                var sub_total_iva = 0;

                if ( $(this).closest('tr').is(':visible') )
                {
                    cantidad = $(this).closest('tr').find('input[id=cantidad]').val() ;

                    if(cantidad=='')
                        cantidad=0;

                    cantidad = cantidad.split(",").join(".");

                    precio_unitario = $(this).closest('tr').find('input[id=precio_unitario]').val() ;
                        if(precio_unitario=='')
                            precio_unitario=0;

                    iva = $(this).closest('tr').find('select[id=iva]').val() ;
                }

                sub_total = parseInt( cantidad*precio_unitario );

                if(iva!=0)
                    iva_sub_total = parseInt(sub_total/iva);
                else
                    iva_sub_total = 0;

                if(iva==11)
                {
                    total_iva_10 += iva_sub_total;
                }
                else if(iva==21)
                {
                    total_iva_5 += iva_sub_total
                }

                total_ivas += iva_sub_total

                sub_total_mas_iva = sub_total/*+iva_sub_total*/;

                $(this).closest('tr').find('input[id=sub_total]').val( $.number( sub_total, 0, '', '.') );

                $(this).closest('tr').find('input[id=total]').val( $.number( sub_total_mas_iva, 0, '', '.') );

                total_sin_iva += sub_total;

                total += sub_total_mas_iva;

                //console.log('cantidad= '+cantidad+' iva= '+iva+' precio unitario= '+precio_unitario+' subtotal= '+sub_total+' iva de subtotal='+iva_sub_total+' subtotal+iva= '+sub_total_mas_iva+' total acumulado= '+total);
            });

            //console.log('total='+total);

            // $("#monto_sub_total").val( $.number( parseInt(total_sin_iva) , 0, '', '.') );

            $("#monto_total").val( $.number( parseInt(total) , 0, '', '.') );



            //$('#monto_total_letras').val(NumeroALetras(total)); 

            $("#total_iva_5").val( $.number( total_iva_5 , 0, '', '.') );

            $("#total_iva_10").val( $.number( total_iva_10 , 0, '', '.') );

            $("#iva_total").val( total );

            $("#total_pagar").val( $("#monto_total").val() );

            $("#total_iva").val( $.number( parseInt(total_ivas) , 0, '', '.') );

        }


        function setup_inicializar_inputs()
		{
			$('.cantidad').number(true, 0, '', '.');

			$('.precio_unitario').number(true, 0, '', '.');

			$('.sub_total').number(true, 0, '', '.');

            $('#total_pagado').number(true, 0, '', '.');

			$('#total').number(true, 0, '', '.');

			$('#monto_total').number(true, 0, '', '.');

            //$('#ruc').number(true, 0, '', '');

            //$('#telefono').number(true, 0, '', '');

			$('#total_iva_10').number(true, 0, '', '.');

			$('#total_iva_5').number(true, 0, '', '.');

			$('#total_iva').number(true, 0, '', '.');
/*
			$('#fecha').datetimepicker(
	        {
	            format: 'DD/MM/YYYY',
	            //format: 'YYYY-MM-DD',
	            locale: 'es'
	        });
*/
		};



		function setup_add_row_with_enter_key()
		{
			$(window).keydown(function(event)
            {
                if(event.keyCode == 13) 
                {

                  event.preventDefault();

                  $("#agregar").click();
                  
                  return false;
                  
                }
            });
		};

		function setup_global_autocomplete_false()
		{
			$('input').each(function()
			{
				$(this).attr('autocomplete','off');
			});
		};

        function get_row_from_table()
        {
            var row = get_first_row();

            row = fix_for_use_on_append_function(row);

            row = reset_all_inputs(row);

            return row;
        };

        function get_first_row()
        {
            return $("tr.fila").html();
        };

        function fix_for_use_on_append_function(html_code)
        {
            return html_code.replace(/\r?\n|\r/g, "");
        };

        function reset_all_inputs(html_code)
        {
            html_code = html_code.replace(/" value=/g,'" value="" v');

            html_code = html_code.replace(/option value="0" selected="selected"/g,'option value="0"');
            html_code = html_code.replace(/option value="21" selected="selected"/g,'option value="21"');
            html_code = html_code.replace(/option value="11">/g,'option value="11" selected="selected">');

            html_code = html_code.replace(/id="detalle_id" value/g,'id="detalle_id" value="0"');
            html_code = html_code.replace(/id="eliminar" value/g,'id="eliminar" value="0"');

            //html_code = html_code.trim();
            //
            return html_code;
        };

        function log( data )
        {
            console.log(data);
        };

        $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.ventas.facturaventa.index') }}" }]});
	});
</script>