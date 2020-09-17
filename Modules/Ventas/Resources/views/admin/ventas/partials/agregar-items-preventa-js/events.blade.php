<script type="text/javascript" charset="utf-8">
	BUTTON_AGREGAR_ITEM.click(function(event)
	{
		button_agregar_item_was_clicked();
	});
	SELECT_TIPO.change(function(event)
	{
		select_tipo_was_changed( $(this).val() );
		INPUT_DESCRIPCION.focus();
	});
	SELECT_CRISTAL_ID.change(function(event)
	{
		load_datos_cristal( $(this).val() )
	});
	INPUT_CANTIDAD.keyup(function()
	{
		calculate_all_agregar_item();
	});
	INPUT_PRECIO_UNITARIO.keyup(function()
	{
		calculate_all_agregar_item();
	});
	BUTTON_ACTUALIZAR.click(function()
	{
		actualizar();
	});
	MODAL_AGREGAR_ITEM.on('shown.bs.modal', function() 
	{
    	INPUT_DESCRIPCION.focus();
	})
</script>