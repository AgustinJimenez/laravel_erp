{!! Theme::script('js/jquery.number.min.js') !!}
{!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}
{!! Theme::style('css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') !!}
{!! Theme::script('vendor/jquery-ui/ui/minified/i18n/datepicker-es.min.js') !!}

<script type="text/javascript">
	$(document).ready(function()
	{
		$(".monto").number( true , 0, '', '.' );
		$(".fecha").datepicker($.datepicker.regional[ "es" ]);
		$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});
    	$(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.empleados.anticipos.index') }}" }]});
	});
</script>