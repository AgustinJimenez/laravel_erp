@section('scripts')

    {!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}

    {!! Theme::script('js/NumeroALetras.js') !!}

    {!! Theme::script('js/moment.js') !!}

    {!! Theme::script('js/moment.es.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}

    {!! Theme::script('js/jquery.number.min.js') !!}

    {!! Theme::script('js/jquery.chained.min.js') !!}

    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}

    {!! Theme::style('css/jquery-ui.min.css') !!}

    
    
<script type="text/javascript">

        $( document ).ready(function() 
        {
            //$('a.navbar-btn.sidebar-toggle').click();
            var c = 1;
            var n = 1;
            //console.log($('#resta').val());
            $("input").each(function()
            {
                $(this).attr('autocomplete','off');
            });

            $(".nro_sobre1").keyup(function()
            {
                $(".nro_sobre2").val( $(this).val() );
            });

            $("input[name=nro_seguimiento]").change(function()
            {
                $("#nro_boleta").val( $(this).val() );
            });

            $("select[name=tipo_factura]").change(function()
            {
                var factura = $(this).val();
                //alert(factura);
                if (factura == "credito") 
                {
                    $("#total_pagado").val(0);
                    $("#total_pagado").attr('readonly',true);
                }
                else
                {
                    $("#total_pagado").attr('readonly',false);
                }
                
            });
            
            var estado = '{{ isset($venta)?$venta->estado:'' }}';

            var tipo = '{{ isset($venta)?$venta->tipo:'' }}';

            if(estado == 'terminado' || tipo == 'preventa')
            {
                $('input').each(function(event)
                {
    //INPUTS QUE NO VAN A SER BLOQUEADOS
                    if
                    ( 
                        $(this).attr('id') != 'anulado' && 
                        $(this).attr('name') != '_token' && 
                        $(this).attr('name') != 'nro_factura' && 
                        $(this).attr('name') != '_method' && 
                        $(this).attr('name') != 'pago_final' && 

                        $(this).attr('name') != 'detalle[producto_id]' && 
                        $(this).attr('name') != 'detalle[servicio_id]' && 
                        $(this).attr('name') != 'detalle[cristal_id]' && 
                        $(this).attr('name') != 'detalle[descripcion]' && 
                        $(this).attr('name') != 'detalle[categoria_cristal]' && 
                        $(this).attr('name') != 'detalle[cristal]' && 
                        $(this).attr('name') != 'detalle[cristal_id]' && 
                        $(this).attr('name') != 'detalle[cantidad]' &&
                        $(this).attr('name') != 'detalle[precio_unitario]' &&
                        $(this).attr('name') != 'detalle[precio_total]'
                    @if( isset($venta) and !$venta->anulado )
                        && 
                        $(this).attr('name') != 'fecha_venta'
                    @endif 
//SI DECTECTA QUE USUARIO TIENE PERMISOS DE EDITAR NRO SEGUIMIENTO ESTE LO HABILITA
                    @if( isset($permisos) and $permisos->has('Permisos Especiales Ventas') and $permisos->get('Permisos Especiales Ventas')['Editar nro de sobre en Completar Venta'] and isset($venta) and !$venta->anulado)
                        &&
                        $(this).attr('name') != 'nro_seguimiento'
                    @endif
                    )
                        $(this).attr('readonly', '');
                   // console.log( $(this).attr('name') );
                });

                $('select').each(function(event)
                {
                    if
                    (
                        $(this).attr('name') != 'forma_pago' && 
                        $(this).attr('name') != 'tipo_factura' &&
                        $(this).attr('name') != 'detalle[tipo]' && 
                        $(this).attr('name') != 'detalle[iva]' &&
                        $(this).attr('id') != 'detalle_categoria_cristal' && 
                        $(this).attr('id') != 'detalle_cristal' && 
                        $(this).attr('id') != 'detalle_cristal_id'
                    )
                        $(this).attr('readonly', '');
                });

                $("textarea[name=observacion_venta]").attr('disabled', true).attr('readonly', '');

                $("#agregar").attr('disabled', true).attr('style', 'display:none');

                $("p.btn-danger").attr('disabled', true).attr('readonly', '').attr('style', 'display:none');
            };

            @if( isset($venta) && !old('cliente') )
                $("input[name=cliente]").val('{{ $venta->cliente->razon_social }}');
            @endif

            @if(isset($detalles))
                @foreach($detalles as $key => $detalle)
                    
                    x = {{ $key }}

                    $('.sub_total'+x).number(true, 0, '', '');
                    
                   // console.log('x is for inicialize chains-> '+x);


                    if(estado != 'preventa')
                    {
                        $(".select_cristal"+x).chained(".select_categoria_cristal"+x);

                        $(".select_tipo_cristal"+x).chained(".select_cristal"+x);
                    }
                
                    
                
                @endforeach
            @endif

            @if( old('cantidad') )
               // console.log('IS OLD');
                @foreach( old('cantidad') as $key => $val )
                    
                    x={{ $key }};
                
                    $("#cristal"+x).chained("#categoria_cristal"+x);

                    $("#tipo_cristal"+x).chained("#cristal"+x);
                @endforeach
            @endif

            localStorage.clear();
            //$('#mensaje_precio').hide();

            //$('#mensaje_monto_total').hide();

            $("#isVenta").attr('tabIndex', "-1");

            $("#cliente_id").attr('tabIndex', "-1");

            $("#producto_id").attr('tabIndex', "-1");

            $("#servicio_id").attr('tabIndex', "-1");

            $("#cristal_id").attr('tabIndex', "-1");

            $("#sub_total").attr('tabIndex', "-1");

            $("#monto_total_iva").attr('tabIndex', "-1");
             $("#descuento_total").attr('tabIndex', "-1");

            $("#monto_total").attr('tabIndex', "-1");
            $("#monto_total_letra").attr('tabIndex', "-1");
            $("#total_iva_5").attr('tabIndex', "-1");
            $("#total_iva_10").attr('tabIndex', "-1");
            $("#total_iva").attr('tabIndex', "-1");

            $("button[data-target=#clienteModal]").attr('tabIndex', "-1");
            
            $('#entrega').number(true, 0, '', '.');

            //$("#entrega").attr('required','');

            $('#total_pagado').number(true, 0, '', '.'); 

            $('.total_pagar').number(true, 0, '', '.');

            $('#vuelto').number(true, 0, '', '.');

            $("#monto_total_iva").number(true, 0, '', '.');
           
            $("#descuento_total").number(true, 0, '', '.');

            $("#pago_final").number(true, 0, '', '.');

            $('.cantidad').number(true, 1, ',', '.');

            $('.precio_unitario').number(true, 0, '', '.');

            $('.precio_descuento').number(true, 0, '', '.');

            $(".select_cristal0").chained(".select_categoria_cristal0");

            $(".select_tipo_cristal0").chained(".select_cristal0");

            $('.sub_total').number(true, 0, '', '.');

            $('#entrega').attr("required","");

            $('#monto_total').prop('readonly', true);

            $('#monto_total_letra').prop('readonly', true);

            $('#total_iva_5').prop('readonly', true);

            $('#total_iva_10').prop('readonly', true);

            $('#total_iva').prop('readonly', true);

            $("#activo").prop('checked',true);

            $('#entrega_preventa').number(true, 0, '', '.');

            $('#restante_preventa').number(true, 0, '', '.');

           calculate_all()

           $("#generar_factura").click(function(event)
           {
                $("input[name=generar_factura]").val(1); 

                $(".submit_button").click();
           });

           
            
            
                $(window).keydown(function(event)
                {
                    if(event.keyCode == 13) 
                    {
                      event.preventDefault();
                      //$("#agregar").click();
                      
                    // return false;
                    }
                });
            

            $(".submit_button").click(function(e)
            {
                var cliente_id_error_message = '';

                var total_pagado_insuficiente_preventa = '';

                var cliente_id = $("#cliente_id").val();

               // console.log( 'cliente_id es ['+cliente_id+'] ' );

                if( cliente_id == '')
                {
                    cliente_id_error_message = '-Seleccione correctamene al cliente en la lista desplegable\n';
                }

                var detalle_objeto_id_error_message = '';

                var row = 1;

                $(".cantidad").each(function() 
                {
                    var producto_id = $(this).closest('td').closest('tr').find('input[id=producto_id]').val();

                    var servicio_id = $(this).closest('td').closest('tr').find('input[id=servicio_id]').val();

                    var cristal_id = $(this).closest('td').closest('tr').find('input[id=cristal_id]').val();

                    if(producto_id=='' && servicio_id=='' && cristal_id=='')
                    {
                        detalle_objeto_id_error_message = detalle_objeto_id_error_message+'-No se selecciono ningun elemento en la fila '+row+'\n';
                    }


                    row+=1;
                    
                });

                if(tipo == 'preventa')
                {
                    var total_a_pagar = parseInt( $("input[name=total_a_pagar_factura]").val() );

                    var entrega = parseInt( $("input[name=entrega]").text());

                    var pago_final = parseInt( $("input[name=pago_final]").val() );

                    //console.log('total a pagar ='+total_a_pagar+' entrega='+entrega+' pago_final='+pago_final+ ' suma='+(entrega+pago_final) );

                }


                if( cliente_id_error_message == '' &&  detalle_objeto_id_error_message == '')
                {
                    //e.preventDefault();
                    //console.log('testing');
                    $("#submit_button").submit();
                }
                else
                {
                    alert( cliente_id_error_message+' '+detalle_objeto_id_error_message);

                    e.preventDefault();
                }
            });

            $('#fecha_venta').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });
            $('#fecha_entrega').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            

            $('#div_tabla').on('change','.select_tipo_cristal_ajax', function () 
            {
                var search_id = $(this).val();
                
                var place = $(this);

                $.ajax(
                {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{!! route('admin.cristales.tipocristales.search_cristal') !!}',
                    type: 'GET',
                    data: {id: search_id}, 
                    dataType: 'json',
                    success: function( precio_unitario )
                    {
                        place.closest('td').closest('tr').find('input[id=precio_unitario]').val(precio_unitario);
                        place.closest('td').closest('tr').find('input[id=cristal_id]').val(search_id);
                        calculate_all();   
                    }
                });
            });

            $(".seguimiento").on('keyup', function()
            {
                $("#nro_seguimiento_preventa").val( $(this).val() );

                $("#nro_seguimiento_factura").val( $(this).val() );

            });

            if($("input[name=pago_final]").val() == '')
            {
                calculo_preventa();
            };

            $("input[name=entrega]").keyup(function()
            {
                calculo_preventa();
            });

            $("input[name=entrega_preventa]").keyup(function()
            {
                calculo_preventa();
            });


            function calculo_preventa()
            {

                var total_preventa = $('#total_pagar').val();

                if($('#entrega_preventa').val())
                    var total_pago_preventa = $('#entrega_preventa').val();
                else
                    var total_pago_preventa = $('#entrega').val();                          
                

                if (total_preventa > 0) 
                {
                    

                    var restante_preventa = total_preventa.replace(/\./g,'') - total_pago_preventa.replace(/\./g,'') ;


                    $('#restante_preventa').val(restante_preventa);
                }

                

                if( $("input[name=pago_final]").val() != null || $("input[name=entrega]").val() != null )
                {

                    var entrega = $("input[name=entrega]").val();

                    if(entrega=="")
                        $("input[name=entrega]").val(0);

                    entrega = parseInt(entrega.replace(/\./g,''));

                    var pago_final = $("input[name=pago_final]").val();

                    if(!pago_final)
                        pago_final = '0';



                    pago_final = parseInt(pago_final.replace(/\./g,''));

                    var total_a_pagar_factura = $("input[name=total_a_pagar_factura]").val();

                    total_a_pagar_factura = parseInt(total_a_pagar_factura.replace(/\./g,''));

                    var total_pagado = entrega + pago_final;

                    var restante = total_a_pagar_factura-entrega;
                    
                    var vuelto = total_pagado-total_a_pagar_factura;


                    if(vuelto<0)
                        vuelto = 0;

                    $("input[name=vuelto_cliente]").val(vuelto);

                    var opcion_seleccionada_select = $('select[name=tipo_factura]').val();

                    if( opcion_seleccionada_select == 'contado')
                    {
                        console.log('entro en contado;');
                         $("input[name=pago_final]").attr('readonly',false);
                        //console.log('total_pagado= '+total_pagado+' pagar es: '+total_a_pagar_factura );

                        if( total_a_pagar_factura <= total_pagado)
                        {
                            $("#guardar").attr('disabled',false);
                            console.log('habilitado boton guardar siendo contado por que el total a pagar es menor  o igual a total pagado');
                        }
                        else
                        {
                            $("#guardar").attr('disabled',true);
                            console.log('deshabilitado boton guardar siendo contado por que el total a pagar es menor al total pagado');
                        }
                        
                    }
                    else 
                    {   
                        console.log('entro en credito');
                        $("#guardar").attr('disabled',false);
                        $("input[name=pago_final]").val(0).attr('readonly','');
                        console.log('habilitado boton guardar siendo credito');
                    }
                        
                    }

                    /*
                    console.log('restante='+restante+" pago_final="+pago_final);
                    if (restante<pago_final) 
                    {
                        //alert('yes');
                        $("#guardar").attr('disabled',true);
                        console.log('deshabilitado');
                    } 
                    */
                
            }

            $("input[name=pago_final]").on('keyup', function()
            {
                calculo_preventa();
            });

            function calculate_vuelto()
            {
                if( !$("input[name=pago_final]").val())
                {
                    var pago_cliente = $("input[name=total_pagado]").val();

                    var total_pagar = $("input[name=total_a_pagar_factura]").val();

                    total_pagar = total_pagar.replace(/\./g,'');

                    var diferencia = total_pagar-pago_cliente;

                    //console.log('Calculate vuelto: total a pagar: '+total_pagar+' el cliente pago: '+pago_cliente+' la diferencia es: '+diferencia);

                    if( diferencia<0 )
                    {
                        //console.log('dif negativa');
                        $("#vuelto").val( diferencia*-1 );
                    }
                    else
                    {
                        $("#vuelto").val( 0 );
                    }

                    if($('select[name=tipo_factura]').val() == 'contado')
                    {
                        //console.log( 'pago_cliente='+pago_cliente+' < total_pagar='+total_pagar );

                        if ($('#resta').val()< pago_cliente) 
                        {
                            $("#generar_factura").attr('disabled',true);
                        }
                        if(+pago_cliente<+total_pagar)
                        {
                            $("#generar_factura").attr('disabled',true);

                            //console.log( 'disabled' );
                        }
                        else
                        {
                            if(total_pagar>0)
                                $("#generar_factura").attr('disabled',false);
                        }

                    }
                    else
                        $("#generar_factura").attr('disabled',false);
                }

                @if( isset($venta) )
                    precalculo();
                @endif
                
            }

            var pago_final = $("input[name=pago_final]").val();

            var entrega = $("input[name=entrega]").val();

            var total_pagado = $("input[name=total_pagado]").val();

            if( pago_final=='0' )
                $("input[name=pago_final]").val('&nbsp;') 
            if( entrega=='0' )
                $("input[name=entrega]").val('&nbsp;') 
            if( total_pagado=='0' )
                $("input[name=total_pagado]").val('&nbsp;') 

            $('select[name=tipo_factura]').change(function()
            {
                calculate_all();
                calculo_preventa();

                var pago_final = $("input[name=pago_final]").val();

                var entrega = $("input[name=entrega]").val();

                var total_pagado = $("input[name=total_pagado]").val();

                if( pago_final=='' )
                    $("input[name=pago_final]").val('0') 
                if( entrega=='' )
                    $("input[name=entrega]").val('0') 
                if( total_pagado=='0' )
                {
                    //console.log('detected');

                    $("input[name=total_pagado]").val('&nbsp;') 
                }
            });

            $("input[name=pago_final]").keyup(function()
            {
                calculo_preventa();
            });

            $("input[name=total_pagado]").keyup(function()
            {
                calculate_all();
            });

            $("#descuento_total").keyup(function()
            {

                calculate_all();
            });


            $( "#cliente" ).autocomplete(
            {
                source: '{!! route('admin.clientes.cliente.search_cliente') !!}',

                minLength: 1,

                select: function(event, ui) 
                {
                    $( "#cliente_id" ).val( ui.item.id );

                    $( "input[name=ruc]" ).val( ui.item.ruc );
                }

            });

            $( ".producto" ).autocomplete(
            {
                source: '{!! route('admin.productos.producto.search_producto') !!}',

                minLength: 1,

                select: function(event, ui) 
                {
                    $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val(ui.item.precio);
                    $(this).closest('td').closest('tr').find('input[id=precio_hide]').val(ui.item.precio);
                    $(this).closest('td').closest('tr').find('input[id=producto_id]').val(ui.item.id);
                    $(this).closest('td').closest('tr').find('input[id=cantidad]').keyup();
                }

            });

            $( ".servicio" ).autocomplete(
            {
                source: '{!! route('admin.servicios.servicio.search_servicio') !!}',

                minLength: 1,

                select: function(event, ui) 
                {
                    $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val(ui.item.precio);
                    $(this).closest('td').closest('tr').find('input[id=servicio_id]').val(ui.item.id);
                    $(this).closest('td').closest('tr').find('input[id=cantidad]').keyup();
                }

            });


            
            @if(isset($detalles))
                var x = {{ count($detalles) }};
                var mark = '[indexAgregado]';
            @else 
                var x = 0;  
                var mark = '0';
            @endif

            @if( old('cantidad') )
                x = {{ count(old('cantidad')) }}
            @endif

           // console.log('x ready: '+x);

            $('#agregar').click(function (e) 
            {

                e.preventDefault();
                x++;

               // console.log('agregar clicked, '+'x is: '+x);
    
                column_seleccion=column_seleccion.replace('select_cristal'+mark,'select_cristal'+x);
                column_seleccion=column_seleccion.replace('select_categoria_cristal'+mark,'select_categoria_cristal'+x);
                column_seleccion=column_seleccion.replace('select_tipo_cristal'+mark,'select_tipo_cristal'+x);
                
                $('#tabla_detalle_venta').append(
                '<tr id="'+x+'">'+column_tipo+''+column_seleccion+''+column_detalleCristal+''+column_cantidad+''+column_iva+''+column_precioUnitario+''+column_precio+''+column_subtotalMasIva+''+column_accion+'</tr>');

                column_seleccion=column_seleccion.replace('select_cristal'+x,'select_cristal'+mark);
                column_seleccion=column_seleccion.replace('select_categoria_cristal'+x,'select_categoria_cristal'+mark);
                column_seleccion=column_seleccion.replace('select_tipo_cristal'+x,'select_tipo_cristal'+mark);



                $('.precio_unitario').number(true, 0, '', '.');

                $('.cantidad').number(true, 1, ',', '.');
                
                $('.precio_descuento').number(true, 0, '', '.');

                $(".select_cristal"+x).chained(".select_categoria_cristal"+x);

                $(".select_tipo_cristal"+x).chained(".select_cristal"+x);

                $(this).closest('td').closest('tr').find('div[id=divProductos]').hide().find('input').val('').removeAttr("required");


                if(x<0)
                {
                    x=0;
                  //  console.log('x fixed to: '+x);
                }

                $( ".producto" ).autocomplete(
                {
                    source: '{!! route('admin.productos.producto.search_producto') !!}',

                    minLength: 1,

                    select: function(event, ui) 
                    {
                        $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val(ui.item.precio);
                        $(this).closest('td').closest('tr').find('input[id=precio_hide]').val(ui.item.precio);
                        $(this).closest('td').closest('tr').find('input[id=producto_id]').val(ui.item.id);
                        $(this).closest('td').closest('tr').find('input[id=cantidad]').keyup();
                    }

                });

                $( ".servicio" ).autocomplete(
                {
                    source: '{!! route('admin.servicios.servicio.search_servicio') !!}',

                    minLength: 1,

                    select: function(event, ui) 
                    {
                        $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val(ui.item.precio);
                        $(this).closest('td').closest('tr').find('input[id=servicio_id]').val(ui.item.id);
                        $(this).closest('td').closest('tr').find('input[id=cantidad]').keyup();
                    }

                });

            });
            


            var column_tipo = '{!! php_to_js( $columnTipo) !!}';
            var column_seleccion = '{!! php_to_js( $columnSeleccion) !!}';    
            var column_detalleCristal = '{!! php_to_js( $columnDetalleCristal) !!}';  
            var column_cantidad =  '{!!  php_to_js( $columnCantidad) !!}'; 
            var column_iva = '{!!  php_to_js( $columnIva) !!}'; 
            var column_precioUnitario = '{!!  php_to_js( $columnPrecioUnitario) !!}'; 
            var column_precio = '{!!  php_to_js( $columnPrecioTotal) !!}'; 

            var column_subtotalMasIva = '{!!  php_to_js( $columnSubTotal) !!}'; 
            var column_accion = '{!!  php_to_js( $columnAccion) !!}'; 


            <?php 
                function php_to_js( $code ){return trim(preg_replace('/\s\s+/', ' ', htmlspecialchars_decode($code)));}
            ?>

            $("#div_tabla").on('change','.tipo',function()
            {

                if($(this).val()=='cristal')
                {

                  //  console.log('cristal selected, now hide servicios and productos')

                    $(this).closest('td').closest('tr').find('div[id=divProductos]').hide().find('input').val('').removeAttr("required")/*.prop('disabled',true)*/;
                    $(this).closest('td').closest('tr').find('div[id=divServicios]').hide().find('input').val('').removeAttr("required")/*.prop('disabled',true)*/;
                    $(this).closest('td').closest('tr').find('div[id=divCristales]').show().find('input')/*.removeAttr('disabled')*/;

                    $(this).closest('td').closest('tr').find('select[id=categoria_cristal]').attr("required","").val('');
                    $(this).closest('td').closest('tr').find('select[id=cristal]').attr("required","").val('');
                    $(this).closest('td').closest('tr').find('select[id=tipo_cristal]').attr("required","").val('');


                    $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val('');
                    $(this).closest('td').closest('tr').find('input[id=sub_total]').val('0');
                    $(this).closest('td').closest('tr').find('input[id=producto_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=servicio_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=cantidad]').val('');
                    calculate_all()
                }   
                else
                {
                    $(this).closest('td').closest('tr').find('div[id=columnDetalleCristal]').hide();
   
                }

                if($(this).val()=='servicio')
                {
                    //console.log('servicios selected, now hide productos and cristales')
                    $(this).closest('td').closest('tr').find('div[id=divProductos]').hide()/*.prop('disabled',true)*/.find('input').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('div[id=divServicios]').show().find('input')/*.removeAttr('disabled')*/.attr("required","");
                    $(this).closest('td').closest('tr').find('div[id=divCristales]').hide()/*.prop('disabled',true)*/;
                    $(this).closest('td').closest('tr').find('select[id=categoria_cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('select[id=cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('select[id=tipo_cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('input[id=producto_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=cristal_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val('');
                    $(this).closest('td').closest('tr').find('input[id=cantidad]').val('');
                    $(this).closest('td').closest('tr').find('input[id=sub_total]').val('0');
                    calculate_all()

                }

                if($(this).val()=='producto')
                {
                    //console.log('productos selected, now hide servicios and cristales')
                    $(this).closest('td').closest('tr').find('div[id=divProductos]').show().find('input')/*.removeAttr('disabled')*/.attr("required","");
                    $(this).closest('td').closest('tr').find('div[id=divServicios]').hide()/*.prop('disabled',true)*/.find('input').val('').removeAttr("required");
                    $(this).closest('td').closest('tr').find('div[id=divCristales]').hide()/*.prop('disabled',true)*/.find('input').val('').removeAttr("required");
                    $(this).closest('td').closest('tr').find('select[id=categoria_cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('select[id=cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('select[id=tipo_cristal]').removeAttr("required").val('');
                    $(this).closest('td').closest('tr').find('input[id=servicio_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=cristal_id]').val('');
                    $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val('');
                    $(this).closest('td').closest('tr').find('input[id=cantidad]').val('');
                    $(this).closest('td').closest('tr').find('input[id=sub_total]').val('0');
                    calculate_all()
                }
            });

            $("#div_tabla").on("click",'.remove_field', function(e)
            {
                e.preventDefault();
                $(this).parent().parent('tr').remove();
                
               // console.log('function remove row ,x es: ');

                calculate_all();
                $("#total_pagado").keyup();
            });

            $("#div_tabla").on("click",'.remove_field_eliminar', function(e)
            {
                e.preventDefault();

                $(this).closest('td').closest('tr').find("input[id=eliminar]").val('1');

                $(this).parent().parent('tr').hide();

                calculate_all()
            });

            $('#div_tabla').on('keyup','.cantidad', function () //si se escribe en cantidad
            {
                calculate_all();
            });

            $('#div_tabla').on('keyup','.precio_descuento', function () //si se escribe en cantidad
            {
                calculate_all();
            });


            var k=0;
            $('#div_tabla').on('keyup','.precio_unitario', function (e) //si se escribe en precio unitario
            {
                e.preventDefault();
                e.stopImmediatePropagation();

                var precio_unitario =  + $(this).closest('td').closest('tr').find("input[id=precio_unitario]").val();
                var precio_hide_val =  + $(this).closest('td').closest('tr').find("input[id=precio_hide]").val();
                
                
                console.log("Precio de Articulo =", precio_hide_val);
                //// console.log("Precio Unitario =", precio_unitario);

                if (precio_unitario < precio_hide_val) 
                {   
                    $('.input-sm').prop('disabled', true);
                    $('#agregar').hide();
                    $(this).closest('td').closest('tr').find("input[id=cantidad]").attr('readonly', true);
                    $(this).closest('td').closest('tr').find("input[class=producto]").attr('readonly', true);
                    $('#precio_unitario').focus();
                    $(this).css('background-color',"#dd4b39");
                    k=k+1;
                    if (c==1) {
                        $.alert
                        ({
                            title: 'Error',
                            content: 'No se puede modificar el precio a un monto menor!',
                        });
                        c=c+1;
                    }

                    //console.log(c);
                    //alert('No se puede modificar a un menor precio');
                }
                else
                {
                    c = 1;
                    k=k-1;
                    $('#agregar').show();
                    $('.input-sm').prop('disabled', false);
                    $(this).closest('td').closest('tr').find("input[id=cantidad]").attr('readonly', false);
                    $(this).closest('td').closest('tr').find("input[class=producto]").attr('readonly', false);
                    $(this).css('background-color',"");
                    calculate_all();
                }

               
                
            })
            // console.log(k);
            if (k!=0) 
            {
                $('.input-sm').prop('disabled', true);
                $('#agregar').hide();
            }
            else
            {
                $('.input-sm').prop('disabled', false);
                $('#agregar').show();
            }


            $('#div_tabla').on('change','.iva', function () 
            {
                calculate_all();
            })

            function calculate_all()
            {
                var total = 0;
               // console.log($('#descuento_total').val());
                var total_descuento = $('#descuento_total').val();

                var total_iva_5 = 0;

                var total_iva_10 = 0;

                var total_ivas = 0;

                $(".cantidad").each(function() 
                {
                    var cantidad = 0;

                    var precio_unitario = 0;
                    
                    //var descuento = 0;

                    var sub_total = 0;

                    var iva = 0;

                    var sub_total_iva = 0;

                    if ($(this).closest('td').closest('tr').is(':visible'))
                    {
                        cantidad = $(this).val() ;

                        if(cantidad=='')
                            cantidad = 0;

                        cantidad = parseFloat( cantidad );

                        precio_unitario = $(this).closest('td').closest('tr').find('input[id=precio_unitario]').val() ;
                        //descuento = $(this).closest('td').closest('tr').find('input[id=precio_descuento]').val() ;
                           
                            if(precio_unitario=='')
                                precio_unitario=0;
                            parseInt( precio_unitario );
                        
                        iva = $(this).closest('td').closest('tr').find('select[id=iva]').val();
                    }

                    sub_total = parseInt(cantidad*precio_unitario);

                   // console.log( precio_unitario + "*" + cantidad + "=" + sub_total );

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

                    total_ivas += iva_sub_total;

                    sub_total_iva = sub_total/*+iva_sub_total*/;

                    $(this).closest('td').closest('tr').find('input[id=sub_total]').val( $.number( sub_total_iva, 0, '', '.') );
                    //$(this).closest('td').closest('tr').find('input[id=precio_descuento]').val( $.number(descuento, 0, '', '.') );
                    // total_descuento += descuento;
                    // console.log(total_descuento);
                    total += sub_total_iva;

                    //console.log('sub_total_iva='+sub_total_iva);
                    
                    //total_descuento = total_descuento + parseInt(descuento);
                   // console.log('cantidad= '+cantidad+' iva= '+iva+' precio unitario= '+precio_unitario+' subtotal= '+sub_total+' iva de subtotal='+iva_sub_total+' subtotal+iva= '+sub_total_iva+' total acumulado= '+total);
                });
                //console.log('total_descuento='+total_descuento);

                total = total - total_descuento ;

                //console.log('total='+total);


                if( total < 0 ) 
                {   
                    $('.input-sm').prop('disabled', true);

                    $('#monto_total_iva').css('background-color',"#dd4b39");
                    if (n==1) {
                        $.alert
                        ({
                            title: 'Error',
                            content: 'El Monto Total no puede ser Negativo!',
                        });
                        n=n+1;
                    }
                    //alert('No se puede modificar a un menor precio');
                }
                else 
                {   
                    n=1;
                    $('.input-sm').prop('disabled', false);
                    $('#monto_total_iva').css('background-color',"");
                    $('#mensaje_monto_total').hide();
                    //alert('No se puede modificar a un menor precio');
                }

                $("#monto_total_iva").val( total );

                $("#monto_total").val( $.number( parseInt(total) , 0, '', '.') );

                $("#total_pagar").val( $("#monto_total").val() );
        
                $('#monto_total_letra').val(NumeroALetras(total)); 

                $("#total_iva_5").val( $.number( total_iva_5 , 0, '', '.') );

                $("#total_iva_10").val( $.number( total_iva_10 , 0, '', '.') );

                $("#total_iva").val( $.number( parseInt(total_ivas) , 0, '', '.') );

                if( $("input[name=pago_final]").val() == '' )
                    calculo_preventa();
                else
                    calculate_vuelto();

                @if( isset($venta) )
                    precalculo();
                @endif
            }

            $("input[name=pago_final]").keyup(function(){precalculo();});   

            function precalculo()
            {
                var entrega = $("input[name=entrega]").val();

                var pago_final = $("input[name=pago_final]").val();

                var monto_total = $("input[name=total_a_pagar_factura]").val()

                if(entrega == '')entrega = '0';

                if(pago_final == '')pago_final = '0';

                if(monto_total == '')monto_total = '0';

                var suma_total_pagos = parseInt(( entrega ));

                // monto_total = parseInt( rd( monto_total ) );

                // pago_final = parseInt( rd( pago_final ) );

                // entrega = parseInt( rd( entrega ) );

                var restante = parseInt( monto_total-(entrega+pago_final) );

                if(restante<0)
                    restante = 0;

                //console.log('monto_total='+monto_total+' suma_total_pagos='+suma_total_pagos+' restante='+restante+' pago final='+pago_final+' restante='+restante);

                $("#restante").text( addDots(restante) );

                $("#suma_total_pagos").text( addDots( suma_total_pagos ) );

            }

            function rd(variable)
            {
                return variable.replace(/\./g,'');
            }

            function addDots(nStr) 
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
            }


            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
            {
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

        });   
    </script>
@stop