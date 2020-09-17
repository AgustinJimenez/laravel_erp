{!! Theme::script('js/jquery.number.min.js') !!}
<script type="text/javascript">
	
	
    

	$(document).ready(function()
	{
		console.log('here');
		$('#monto').number(true, 0, '', '.');
/*
		$('#fecha_hora').datetimepicker(
	        {
	            format: 'DD/MM/YYYY',
	            //format: 'YYYY-MM-DD',
	            locale: 'es'
	        });
*/


	});

</script>