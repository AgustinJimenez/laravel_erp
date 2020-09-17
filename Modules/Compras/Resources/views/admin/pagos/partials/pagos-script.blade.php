{!! Theme::script('js/jquery.number.min.js') !!}	
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}

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

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#monto').number(true, 0, '', '.');

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

		$("input").each(function()
        {
            $(this).attr('autocomplete','off');
        });

		$('#fecha').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es',
           // defaultDate: new Date(),
        });

		vuelto();

		$("#formulario").submit(function(event)
		{
			var monto_total = parseInt( $("input[name=monto]").val() );

			if( !monto_total>0 )
			{
				event.preventDefault();
				alert('el monto debe ser mayor a 0');
			}
			else
			{
				$(this).submit();
			}


		});

		function vuelto()
		{
			var vuelto = 0;

			var monto_total = parseInt( rd($("#monto_total").text()) );

			var suma_total_pagos = parseInt( rd($("#suma_total_pagos").text()) );

			var restante = parseInt( rd( $("#restante").text() ) );

			if($("#monto").val() == '')
				var monto = 0;
			else
				var monto = parseInt( $("#monto").val() );

			var vuelto = 0;

			var total_pagado_tmp = suma_total_pagos + monto;

			restante = monto_total - total_pagado_tmp;

			if(restante<0)
			{
				vuelto = restante*-1;

				restante = 0;
			}


			//log('monto_total='+monto_total+' suma_total_pagos='+suma_total_pagos+' restante='+restante+' monto='+monto+' total_pagado_tmp='+total_pagado_tmp+' restante='+restante+'vuelto='+vuelto);

			$("#restante").text( addDots(restante) );

			$("#vuelto").text( addDots(vuelto) );

		}

		$("input[name=monto]").keyup(function(event)
		{

			vuelto();

		});

		function log(variable)
		{
			return console.log(variable);
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

	});
</script>