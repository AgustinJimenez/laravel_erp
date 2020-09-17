@section('scripts')

    {!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}

    {!! Theme::script('js/moment.js') !!}

    {!! Theme::script('js/moment.es.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    {!! Theme::script('js/jquery.number.min.js') !!}

    {!! Theme::script('js/validator.js') !!}

    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}

    {!! Theme::style('css/jquery-ui.min.css') !!}

    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    

    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $('#fecha').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            @if(isset($now))
            $('#fecha').val('{{ $now }}');
            @endif

            $("#fecha").attr('required','');

            $(window).keydown(function(event)
            {
                if(event.keyCode == 13) 
                {
                  event.preventDefault();

                  $("#agregar").click();
                  
                  $("#tabla_detalle_venta").last('tr').find('input[id=cuenta_nombre]').focus();
                  
                  return false;
                }
            });

            $('.debe').number(true, 0, '', '.');

            $('.haber').number(true, 0, '', '.');
            
            $( ".cuenta_nombre" ).autocomplete(
                {
                    source: '{!! route('admin.contabilidad.cuenta.search_cuenta_asiento') !!}',

                    minLength: 1,

                    select: function(event, ui) 
                    {
                        $(this).closest('td').closest('tr').find('input[id=cuenta_id]').val(ui.item.id);
                        $(this).closest('td').closest('tr').find('input[id=cuenta_nombre]').val(ui.item.nombre);

                        console.log('search result: '+ui.item.nombre);
                    }

                });
            
            var x = 0;
            @if( old('observacion') )
                x = {{ count(old('observacion')) }}
            @endif

            console.log('x ready: '+x);

            var row = '{!!  php_to_js( $row ) !!}'; 
            var column_action = '{!!  php_to_js( $column_action ) !!}'; 
            

            <?php function php_to_js( $code ){return trim(preg_replace('/\s\s+/', ' ', htmlspecialchars_decode($code)));}?>

            $(".submit_button").click(function(e)
            {
                var detalle_cuenta_id_error_message = '';

                var row = 1;

                $(".cuenta_id").each(function() 
                {
                    var cuenta_id = $(this).closest('td').closest('tr').find('input[id=cuenta_id]').val();

                    if(cuenta_id=='')
                    {
                        detalle_cuenta_id_error_message = detalle_cuenta_id_error_message+'-No se selecciono apropiadamente ninguna cuenta en la fila '+row+'\n';
                    }


                    row+=1;
                    
                });

                if( detalle_cuenta_id_error_message == '')
                {
                    $("#submit_button").submit();
                }
                else
                {
                    alert( detalle_cuenta_id_error_message);

                    e.preventDefault();
                }
            });

            $('#agregar').click(function (e) 
            {

                e.preventDefault();
                x++;

                //console.log('agregar clicked, '+'x is: '+x);
                
                $('#tabla_detalle_venta').append('<tr id="'+x+'">'+row+''+column_action+'</tr>');

                $('.debe').number(true, 0, '', '.');

                $('.haber').number(true, 0, '', '.');

                if(x<0)
                {
                    x=0;
                    console.log('x fixed to: '+x);
                }

                $( ".cuenta_nombre" ).autocomplete(
                {
                    source: '{!! route('admin.contabilidad.cuenta.search_cuenta_asiento') !!}',

                    minLength: 1,

                    select: function(event, ui) 
                    {
                        $(this).closest('td').closest('tr').find('input[id=cuenta_id]').val(ui.item.id);
                        $(this).closest('td').closest('tr').find('input[id=cuenta_nombre]').val(ui.item.nombre);

                        console.log('search result: '+ui.item.nombre);
                    }

                });

            });

            $("#div_tabla").on("click",'.remove_field', function(e)
            {
                e.preventDefault();
                $(this).parent().parent('tr').remove();
                x--;
                
                if(x<0)
                {
                    x=0;
                    
                }
                console.log('function remove row ,x es: ');

                sumaTotal();
            });

            $("#div_tabla").on("click",'.remove_field_old', function(e)
            {
                console.log('agre');
                $(this).closest('td').closest('tr').find('input[id=eliminar]').val(1);
                e.preventDefault();
                $(this).parent().parent('tr').hide();
                x--;
                
                if(x<0)
                {
                    x=0;
                    
                }
                console.log('function remove row ,x es: ');

                sumaTotal();
            });
            
            $("#div_tabla").on('keyup','.debe',function()
            {
                $(this).closest('td').closest('tr').find('div[id=divDebe]').find('input').attr("required","");

                $(this).closest('td').closest('tr').find('div[id=divHaber]').find('input').val('').removeAttr("required");
                
                sumaTotal();
                
            });

            $("#div_tabla").on('keyup','.haber',function()
            {
                $(this).closest('td').closest('tr').find('div[id=divHaber]').find('input').attr("required","");

                $(this).closest('td').closest('tr').find('div[id=divDebe]').find('input').val('').removeAttr("required");
                
                sumaTotal();
                
            });

            
            
            @if(isset($asiento))
            {
                sumaTotal();
            }
            @endif

            function sumaTotal()
            {
                var suma_total_debe = 0;

                var suma_total_haber = 0;

                var dos_ceros = false;

                $(".debe").each(function() 
                {
                    if ($(this).closest('td').closest('tr').is(':visible'))
                    {
                        var debe = $(this).val();

                        if(debe=='')
                            debe=0;

                        haber = $(this).closest('td').closest('tr').find("input[id=haber]").val();

                        if(haber=='')
                            haber=0;

                        if(haber == 0 && debe == 0)
                            dos_ceros = true;

                        suma_total_debe = suma_total_debe+parseInt( debe );

                        console.log('debe is: '+parseInt( debe ));

                        suma_total_haber = suma_total_haber+parseInt( haber);

                        console.log('haber is: '+parseInt( haber ));
                    }
                });


                $("#total_debe").val( $.number(suma_total_debe, 0, '', '.') );

                $("#total_haber").val( $.number(suma_total_haber, 0, '', '.'));


                if(suma_total_debe==suma_total_haber && suma_total_debe!=0 && dos_ceros==false)
                {
                    $("#submit").removeAttr('disabled');

                    $("#message").hide();
                }
                else
                {
                    console.log('no es igual');
                    $("#submit").prop("disabled", true);
                    $("#message").show();
                }

                
            };


            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});
        });
        $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.contabilidad.asiento.index') }}" }]});
    </script>
@stop