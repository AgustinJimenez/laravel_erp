{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
{!! Theme::script('js/jquery.number.min.js') !!}
<script type="text/javascript">
	$(document).ready(function()
	{



		if({{ isset($is_edit)?$is_edit:0 }})
		{
			console.log('isedit=');

			$('#monto_inicial').attr('readonly', '');

			$('#fecha').attr('readonly', '');
		}

		$('#monto_inicial').number(true, 0, '', '.');
		
		$('#fecha').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es'
        });
	});
</script>