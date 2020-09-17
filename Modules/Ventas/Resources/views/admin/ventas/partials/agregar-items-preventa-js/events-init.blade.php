<script type="text/javascript">
	$(document).ready(function()
	{
		GROUP_CRISTAL.hide();
		INPUT_CANTIDAD.number(true, 1, ',', '.');
		INPUT_PRECIO_UNITARIO.number(true, 0, '', '.');
		INPUT_PRECIO_TOTAL.number(true, 0, '', '.');

		set_producto_autocomplete( INPUT_DESCRIPCION );
		set_cristal_selects_chains();
	});
</script>