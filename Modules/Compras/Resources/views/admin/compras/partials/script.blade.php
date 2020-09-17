    {!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}

    {!! Theme::script('js/NumeroALetras.js') !!}

    {!! Theme::script('js/moment.js') !!}

    {!! Theme::script('js/moment.es.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    {!! Theme::script('js/jquery.number.min.js') !!}

    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}

    {!! Theme::style('css/jquery-ui.min.css') !!}

    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}



    <script>
        $( document ).ready(function()
        {
            localStorage.clear();
/*
            $("#submit").click(function(event)
            {

                if({{ $isProducto }})
                    check_product_id(event);

            });
*/



            $("#proveedor").val( '{{ isset($compra)?$compra->proveedor_nombre->razon_social:'' }}' );

            $('.cantidad').number(true, 1, ',', '.');

            $('.precio_unitario').number(true, 5, ',', '.');

            $('#total_pagado').number(true, 0, '', '.');

            $('input[name=vuelto_cliente]').number(true, 0, '', '.');

            $('#cambio').number(true, 0, '', '.');

            // $('#cambio').number(true, 0, '', '.');

            $("#total_pagado").attr('required','');

            $("input[name=proveedor_id]").attr('tabIndex', "-1");

            $("input[name=isProducto]").attr('tabIndex', "-1");

            $("input[name=isCristal]").attr('tabIndex', "-1");

            $("input[name=isServicio]").attr('tabIndex', "-1");

            $("input[name=isOtro]").attr('tabIndex', "-1");

            $("input[name=total_pagar]").attr('tabIndex', "-1");

            $("input[name=vuelto_cliente]").attr('tabIndex', "-1");

            $("input[name=deber]").attr('tabIndex', "-1");

            $("input[name=haber]").attr('tabIndex', "-1");

            $("#sub_total").attr('tabIndex', "-1");

            $(window).keydown(function(event)
            {
                if(event.keyCode == 13)
                {
                    event.preventDefault();

                    $("#agregar").click();

                    $("#tabla_detalle_venta").last('tr').find('input[id=descripcion]').focus();

                    return false;
                }
            });

            $('#fecha').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $("select[name=moneda]").on('change', function()
            {
                if( $(this).val() == 'Guaranies' )
                    $("#cambio").val('1');

                calculate_all();
            });

            $("#cambio").on('keyup', function()
            {
                if($("select[name=moneda]").val() == 'Guaranies')
                {
                    $("input[name=cambio]").val('1');
                }
                if( $(this).val()=='0')
                {
                    $(this).val('1');
                }

                calculate_all();
            });



                $( "#haber" ).autocomplete(
                {
                    source: '{!! route('admin.contabilidad.cuenta.search_cuenta_asiento') !!}',

                    minLength: 1,

                    select: function(event, ui)
                    {
                        $(".haber_id").val(ui.item.id);
                    }

                });

                $( "#deber" ).autocomplete(
                {
                    source: '{!! route('admin.contabilidad.cuenta.search_cuenta_asiento') !!}',

                    minLength: 1,

                    select: function(event, ui)
                    {
                        $(".deber_id").val(ui.item.id);
                    }

                });
            // });

            $("#total_pagado").on('keyup', function()
            {
                calculate_all();
            });

            var isProducto = '{{ $isProducto }}';
            if(isProducto == '1')
            {
                //console.log('es producto');

                $( ".descripcion" ).autocomplete(
                {
                    source: '{!! route('admin.productos.producto.search_producto') !!}',

                    minLength: 1,

                    select: function(event, ui)
                    {
                        $(this).closest('td').closest('tr').find('input[id=producto_id]').val(ui.item.id);
                    }

                });
            }
            else
                //console.log('no es producto');

            var x = 0;

            @if( old('cantidad') )
                x = {{ count(old('cantidad')) }}
            @endif

            var row = '{!!  php_to_js( $row ) !!}';

            var row_delete = '{!!  php_to_js( $row_delete ) !!}';

            <?php function php_to_js( $code ){return trim(preg_replace('/\s\s+/', ' ', htmlspecialchars_decode($code)));}?>

            $('#agregar').click(function (e)
            {

                e.preventDefault();
                x++;

                //console.log('agregar clicked, '+'x is: '+x);

                $('#tabla_detalle_venta').append(
                '<tr id="'+x+'">'+row+''+row_delete+'</tr>');

                $('.precio_unitario').number(true, 0, '', '.');

                $('.cantidad').number(true, 1, ',', '.');

                if(isProducto == '1')
                {
                    $( ".descripcion" ).autocomplete(
                    {
                        source: '{!! route('admin.productos.producto.search_producto') !!}',

                        minLength: 1,

                        select: function(event, ui)
                        {
                            //NO SE AUTOCOMPLETA
                            //$(this).closest('td').closest('tr').find('input[id=precio_unitario]').val(ui.item.precio);
                            $(this).closest('td').closest('tr').find('input[id=producto_id]').val(ui.item.id);
                        }

                    });
                }

            });

            $("#div_tabla").on("click",'.remove_field', function(e)
            {
                e.preventDefault();
                $(this).parent().parent('tr').remove();

                calculate_all();
            });

            $("#div_tabla").on("click",'.remove_field_old', function(e)
            {
                //console.log( 'REMOVE OLD CLICKED' );

                e.preventDefault();

                $(this).closest('td').closest('tr').find("input[id=eliminar]").val('si');

                $(this).parent().parent('tr').hide();

                calculate_all();
            });

            $('#div_tabla').on('keyup','.cantidad', function () //si se escribe en cantidad
            {
                calculate_all();
            });

            $('#div_tabla').on('keyup','.precio_unitario', function () //si se escribe en precio unitario
            {
                calculate_all();
            })

            $('#div_tabla').on('change','.iva', function ()
            {
                calculate_all();
            });

            $("select[name=moneda]").change(function()
            {
                calculate_all();
            });

            var $sel = $('select[name="tipo_factura"]');

            $sel.on('change', function()
            {
                var tipo_factura = this.value;

                var haber_contado_id = $("input[name=haber_contado_id]").val();
                var haber_contado_nombre = $("input[name=haber_contado_nombre]").val();
                var haber_credito_id = $("input[name=haber_credito_id]").val();
                var haber_credito_nombre = $("input[name=haber_credito_nombre]").val();




                if (tipo_factura == "contado")
                {
                    $('input[id="haber"]').val( haber_contado_nombre );
                    $('input[id="haber_id"]').val( haber_contado_id );
                    $('#total_pagado').val(0);
                    $("#total_pagado").prop("readonly", false);
                    $("#vuelto_cliente").val(0);
                }
                else
                {
                    $('input[id="haber"]').val( haber_credito_nombre );
                    $('input[id="haber_id"]').val( haber_credito_id );
                    $('#total_pagado').val(0);
                    $("#total_pagado").prop("readonly", true);
                    $("#vuelto_cliente").val(0);
                }

                calculate_all();

            });


            function calculate_all()
            {
                var total = 0;

                var total_iva_5 = 0;

                var total_iva_10 = 0;

                var total_ivas = 0;

                $(".cantidad").each(function()
                {
                    var cantidad = 0;

                    var precio_unitario = 0;

                    var sub_total = 0;

                    var iva = 0;

                    var sub_total_iva = 0;

                    var cambio = $("input[name=cambio]").val();

                    if ($(this).closest('td').closest('tr').is(':visible'))
                    {
                        cantidad = $(this).val() ;

                        if(cantidad=='')
                            cantidad=0;

                        precio_unitario = $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val() ;
                            if(precio_unitario=='')
                                precio_unitario=0;

                        iva = $(this).closest('td').closest('tr').find('select[id=iva]').val() ;
                    }


                    sub_total =  cantidad*precio_unitario*cambio ;

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

                    sub_total_iva = sub_total/*+iva_sub_total*/;

                    $(this).closest('td').closest('tr').find('input[id=sub_total]').val( $.number( sub_total_iva, 5, ',', '.') );

                    total += sub_total_iva;

                });

                var letras_total = NumeroALetras(total);

                var moneda_seleccionada = $("select[name=moneda]").val();

                if( moneda_seleccionada == 'Dolares' )
                {

                    $("#precio_unitario_label").text('Precio Unitario (Dolares)')
                }
                else if( moneda_seleccionada == 'Euros' )
                {

                    $("#precio_unitario_label").text('Precio Unitario (Euros)')
                }
                else
                {

                    $("#precio_unitario_label").text('Precio Unitario (Guaranies)')
                }

                $("#monto_total_iva").val( $.number(Math.round(total) , 0, ',', '.') );

                $("#monto_total").val( $.number( Math.round(total) , 0, ',', '.') );

                $("#total_pagar").val( $("#monto_total").val() );

                $('#monto_total_letras').val( letras_total );

                $("#total_iva_5").val( $.number( total_iva_5 , 0, '', '.') );

                $("#total_iva_10").val( $.number( total_iva_10 , 0, '', '.') );

                $("#total_iva").val( $.number( parseInt(total_ivas) , 0, '', '.') );

                calculate_vuelto();

            }

            function calculate_vuelto()
            {
                //console.log( 'total_pagado='+$("#total_pagado").val() );
                //
                var tipo_factura = $("select[name=tipo_factura]").val();

                var pago_cliente = $("#total_pagado").val();

                pago_cliente = pago_cliente.replace(/\./g,' ');

                var total_a_pagar = $("#total_pagar").val();

                total_a_pagar = total_a_pagar.replace(/\./g,'');

                var diferencia = total_a_pagar-pago_cliente;

                //console.log('total a pagar: '+total_a_pagar+' el cliente pago: '+pago_cliente+' la diferencia es: '+diferencia);

                if( diferencia<0 )
                {
                    $("input[name=vuelto_cliente]").val( diferencia*-1 );
                }
                else
                {
                    $("input[name=vuelto_cliente]").val( 0 );
                }

                if(tipo_factura == 'contado')
                {
                    //log('pago_cliente= '+pago_cliente+' total_a_pagar='+total_a_pagar);

                    if( +pago_cliente < +total_a_pagar)
                    {
                        $("#submit").attr('disabled', true);
                    }
                    else
                    {
                        $("#submit").attr('disabled', false);
                    }
                }
                else
                {
                    $("#submit").attr('disabled', false);
                }

            }


            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
            {
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            calculate_all();

            function log(data)
            {
                return console.log(data);
            }

            function check_product_id(event)
            {
                var row=1;

                var producto_id = 0;

                var messaje = '';

                $(".seleccion").each(function()
                {
                    producto_id = $(this).val();

                    log('checking producto_id on '+c+' result='+producto_id);


                    messaje = messaje+'-No se selecciono correctamente ningun producto en la fila '+row+'\n';

                    row++;
                });


                event.preventDefault();

                if(messaje == '')
                    alert('submited');
                else
                    alert(messaje);
            }

            $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.compras.compra.index') }}" }]});
        });
    </script>
