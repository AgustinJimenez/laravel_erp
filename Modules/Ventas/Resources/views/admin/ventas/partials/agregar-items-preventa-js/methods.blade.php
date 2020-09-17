<script type="text/javascript">
	function calculate_all_agregar_item()
	{
		var cantidad = parseFloat( INPUT_CANTIDAD.val() );
		var precio_unitario = parseFloat( INPUT_PRECIO_UNITARIO.val() );
		var precio_total = parseInt( cantidad*precio_unitario );
		//console.log("cantidad = "+cantidad+" precio_unitario = "+precio_unitario+" precio_total = "+precio_total);
		INPUT_PRECIO_TOTAL.val( precio_total );
	}

	function actualizar()
	{
		var error_message = errors();
		if( error_message == "" )
			FORMULARIO_AGREGAR_ITEM.submit();
		else
			show_aviso_modal( error_message );
	}

	function errors()
	{
		mensaje = "";

		if( SELECT_TIPO.val() == "producto" && INPUT_PRODUCTO_ID.val() == "" )
			mensaje += "-No se selecciono ningun producto.";
		else if( SELECT_TIPO.val() == "servicio" && INPUT_SERVICIO_ID.val() == "" )
			mensaje += "-No se selecciono ningun servicio.";
		else if( SELECT_TIPO.val() == "cristal" && SELECT_CRISTAL_ID.val() == "" )
			mensaje += "-No se selecciono ningun cristal.";

		if( INPUT_CANTIDAD.val() == "" )
			mensaje += "<br>-La cantidad es requerida.";

		if( INPUT_PRECIO_UNITARIO.val() == "" )
			mensaje += "<br>-El Precio Unitario es requerido.";

		return mensaje;
	}

	function load_datos_cristal( search_id )
	{
        $.ajax(
        {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '{!! route('admin.cristales.tipocristales.search_cristal') !!}',
            type: 'GET',
            data: {id: search_id}, 
            dataType: 'json',
            success: function( precio_unitario )
            {
                INPUT_PRECIO_UNITARIO.val( precio_unitario );
                calculate_all_agregar_item();   
            }
        });
	}

	function button_agregar_item_was_clicked()
	{
		MODAL_AGREGAR_ITEM.modal("show");
	}

	function select_tipo_was_changed( select_tipo_value )
	{
		if( select_tipo_value == 'cristal' )
		{
			GROUP_DESCRIPTION.hide().find('input').val('');
			GROUP_HIDDENS_ID.find('input').val('');
			GROUP_CRISTAL.show();
		}
		else
		{
			GROUP_HIDDENS_ID.find('input').val('');
			GROUP_DESCRIPTION.show().find('input').val('');
			GROUP_CRISTAL.hide();

			if( select_tipo_value == 'producto' )
				set_producto_autocomplete( INPUT_DESCRIPCION );
			else
				set_servicio_autocomplete( INPUT_DESCRIPCION );

		}
		TEXT_ITEM_SELECTED.text('');
		reset_categoria_cristal_tipo_selects();
	}

	function set_cristal_selects_chains()
	{
		var id_categoria = "#"+SELECT_CATEGORIA_CRISTAL.attr('id');

		var id_cristal = "#"+SELECT_CRISTAL.attr('id');
		SELECT_CRISTAL_ID.chainedTo( id_cristal );
		SELECT_CRISTAL.chainedTo( id_categoria );
	}

	function reset_categoria_cristal_tipo_selects()
	{
		select_set_first_option( SELECT_CRISTAL );
		select_set_first_option( SELECT_CATEGORIA_CRISTAL );
		select_set_first_option( SELECT_CRISTAL_ID );
		SELECT_CATEGORIA_CRISTAL.change();
		SELECT_CRISTAL.change();
	}

	function set_producto_autocomplete( element )
	{
        set_autocomplete( element, '{!! route('admin.productos.producto.search_producto') !!}', INPUT_PRODUCTO_ID )
	}

	function set_servicio_autocomplete( element )
	{
        set_autocomplete( element, '{!! route('admin.servicios.servicio.search_servicio') !!}', INPUT_SERVICIO_ID )
	}

	function set_autocomplete( element, any_source, input_target_id )
	{
		element = remove_autocomplete( element );
		element.autocomplete
		({
            source: any_source,
            minLength: 1,
            select: function(event, ui) 
            {
            	TEXT_ITEM_SELECTED.text( "seleccionado: "+ui.item.value );
                INPUT_PRECIO_UNITARIO.val(ui.item.precio);
                input_target_id.val(ui.item.id);
                calculate_all_agregar_item();
            }
        });
	}

	function remove_autocomplete( element )
	{
		
		if ( element.data('uiAutocomplete') ) 
		  	element.autocomplete("destroy");
		return element;
	}	

	function show_aviso_modal( mensaje )
	{
		MODAL_AVISO_MENSAJE.html( mensaje );
		MODAL_AVISO.modal("show");
	}

	function select_set_first_option( select_element )
	{
		select_element.prop('selectedIndex',0);
	}
</script>