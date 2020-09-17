{!! Theme::script('js/jquery.number.min.js') !!}
{!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}
{!! Theme::style('css/jquery-ui.min.css') !!}
{!! Theme::script('js/jquery.chained.min.js') !!}


<script type="text/javascript">
	$(document).ready(function()
	{
		@if(!isset($cuenta))//si es create
	        $("#activo").prop('checked',true);
	        $("#padre").chained("#tipo");	
	    @else//si es edit
	    	@if(!$cuenta->relacion_cuentas_fijas) //si no tiene relacion con cuenta fija
	        	$("#padre").chained("#tipo");
	        @endif
        @endif
        $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.contabilidad.cuenta.index') }}" }]});
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});

		var input_codigo = $("input[name=codigo]");
		var submit_button = $("button[type=submit]");
		var message_codigo_legend = $(".alert_codigo");
		var select_padre = $("select[name=padre]");
		var input_codigo_base = $("input[name=codigo_base]");
		var label_for_codigo = $("label[for=codigo]");
		input_codigo.number(true, 0, '', '');
		
	/*<=================EVENTOS============================*/
		$("form").submit(function(event)
		{
			se_submitea(event);
		});
		select_padre.change(function()
		{
			input_codigo.keyup();
		})
		input_codigo.keyup(function()
		{
			var codigo_escrito = $(this).val();
			input_codigo_keyup(codigo_escrito);
		});
		/*=================EVENTOS============================>*/

		/*<=================EVENTOS-EDIT============================*/
		@if(isset($cuenta))
			var codigo_completo = "{{ $cuenta->codigo }}";
		    var codigo_elemento = codigo_completo.split(".").pop();
		    input_codigo.val(codigo_elemento).keyup();
			$("input[name=tiene_hijo]").change(function()
			{
			    var tiene_hijo = $(this).val();

			    console.log('cambio a '+tiene_hijo);
			});
		@endif
		/*=================EVENTOS-EDIT============================>*/
		function se_submitea(event)
		{
			var codigo_escrito = input_codigo.val();
			var codigo = get_codigo_final();
			if(codigo_escrito == 0)
			{
				mostrar_modal_con_mensaje(codigo+' no es un codigo valido, no se permiten codigos con 00.');
				event.preventDefault();
			}
			$("input[name=codigo_real]").val(codigo);
		}
		function mostrar_modal_con_mensaje(mensaje)
		{
			$("#mensaje_error_modal").empty();
			$("#mensaje_error_modal").text(mensaje);
			$("#modal-error-confirmation").modal();
		}
		function input_codigo_keyup(codigo_escrito)
		{
			if(+codigo_escrito<10)
			{
				codigo_escrito = '0'+codigo_escrito;
			}
			var codigo = procesar_codigo_escrito(codigo_escrito);
			mostrar_codigo_generado_en_label(codigo);
			check_codigo_if_cuenta_exist( codigo );
		}
		function procesar_codigo_escrito(codigo_escrito)
		{
			//log('codigo_escrito= '+codigo_escrito);
			var codigo_base = cargar_codigo_de_padre();
			input_codigo_base.val(codigo_base + ".");
			var codigo = codigo_base+'.'+codigo_escrito;
			return codigo;
		}
		function check_codigo_if_cuenta_exist(codigo)
		{
			$.get
			(
				'{{ route('admin.contabilidad.cuenta.cuenta_exist') }}', 
				{ 
					codigo:codigo,
					@if(isset($cuenta))
						codigo_edit: "{{ $cuenta->codigo }}"
					@endif
				}
			).done
			(function(data)
				{
					respuesta_a_datos_recibidos(data);
				}
			);
		}
		function respuesta_a_datos_recibidos(cuenta_exist)
		{
			//log("cuenta_exist = "+cuenta_exist);
			if(+cuenta_exist)
				hide_codigo_alert();
			else
				show_codigo_alert();
		};

		function show_codigo_alert()
		{
			submit_button.attr("disabled", false);
			input_codigo.removeClass('input_codigo_warning');
			message_codigo_legend.empty();
			//log('show_codigo_alert()');
		}

		function hide_codigo_alert()
		{
			submit_button.attr("disabled", true);
			input_codigo.addClass('input_codigo_warning');
			message_codigo_legend.text('El codigo ya existe');
			//log('hide_codigo_alert()');
		}
		function extract_code(codigo)
		{
			var codigo_extraido_con_espacio = codigo.split("-").shift();
			var codigo_extraido = codigo_extraido_con_espacio.replace(" ", "");
			return  codigo_extraido;
		}
		function cargar_codigo_de_padre()
		{
			var opcion_seleccionada = $("select[name=padre] option:selected").text();
			var codigo_padre = extract_code(opcion_seleccionada);
			return codigo_padre;
			//log('select_padre value is '+padre_seleccionado+' and text= '+codigo_padre);
		}
		function mostrar_codigo_generado_en_label(codigo_generado)
		{
			label_for_codigo.text("Codigo: "+codigo_generado);
		}
		function get_codigo_final()
		{
			var codigo_con_label = label_for_codigo.text();
			var codigo_extraido_con_espacio = codigo_con_label.split(":").pop();
			var codigo_extraido = codigo_extraido_con_espacio.replace(" ", "");
			return  codigo_extraido;
		}
		function log(data)
		{
			return console.log(data);
		}
	});
</script>

