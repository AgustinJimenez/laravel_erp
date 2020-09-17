
{!! Theme::script('js/jquery.number.min.js') !!}
<script type="text/javascript">
$(document).ready(function()
{
	$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});

	setup_inicializar_inputs();

	calculate_all();

	$(".checkbox").click(function(event)
	{
		event.preventDefault();
	});

    $(".eliminar-pago-button").on('click',function(event)
    {
        event.preventDefault();

        var button = $(this);

        var modal_target = button.attr('data-target');

        $(modal_target).modal();

    });

	function calculate_all()
    {
        var total = 0;

        var total_sin_iva = 0;

        var total_iva_5 = 0;

        var total_iva_10 = 0;

        var total_ivas = 0;

        var cambio = $.number( $("input[name=cambio]").val(), 0, '', '');

        var moneda = $("input[name=moneda]").val();

        $(".fila").each(function() 
        {
            var cantidad = 0;

            var precio_unitario = 0;

            var sub_total = 0;

            var iva = 0;

            var sub_total_iva = 0;

            if ( $(this).closest('tr').is(':visible') )
            {
                cantidad = $(this).closest('tr').find('input[id=cantidad]').val();

                if(cantidad=='')
                    cantidad=0;
                cantidad = cantidad.split(",").join("."); 
                precio_unitario = $(this).closest('tr').find('input[id=precio_unitario]').val() ;
                    if(precio_unitario=='')
                        precio_unitario=0;

                iva = $(this).closest('tr').find('select[id=iva]').val() ;
            }

            sub_total = parseInt( cantidad*precio_unitario*cambio );

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

            //console.log('cantidad= '+cantidad+' iva= '+iva+' precio unitario= '+precio_unitario+' moneda='+moneda+' cambio='+cambio+' subtotal= '+sub_total+' iva de subtotal='+iva_sub_total+' subtotal+iva= '+sub_total_mas_iva+' total acumulado= '+total);
        });

	}

	function setup_inicializar_inputs()
	{

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

	};
});
</script>
