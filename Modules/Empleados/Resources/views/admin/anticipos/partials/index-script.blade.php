<script type="text/javascript">

    $(".eliminar-anticipo").click(function()
    {
        var descontado = $(this).attr('descontado');
        var ruta = $(this).attr("ruta");
        log("descontado="+descontado+" ruta="+ruta);
        
        if( parseInt(descontado) )
        {
            $("#mensaje-eliminar").hide();
            $("#mensaje-no-eliminar").show();
            $("#boton-confirmacion-eliminar").attr("style", "display:none");
        }
        else
        {
            $("#mensaje-eliminar").show();
            $("#mensaje-no-eliminar").hide();
            $("#boton-confirmacion-eliminar").attr("style", "");
        }
        $("#delete-form").attr('action', ruta);
        $("#anticipo-delete-confirmation").modal('show');
    });

	var table = $('.data-table').DataTable
	({
        "paginate": true,
        "lengthChange": true,
        "filter": true,
        "sort": true,
        "info": true,
        "autoWidth": true,
        "order": [[ 0, "desc" ]],
        language: {
            processing:     "Procesando...",
            search:         "Buscar",
            lengthMenu:     "Mostrar _MENU_ Elementos",
            info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
            infoEmpty:      "Mostrando 0 registros",
            infoFiltered:   ".",
            infoPostFix:    "",
            loadingRecords: "Cargando Registros...",
            zeroRecords:    "No existen registros disponibles",
            emptyTable:     "No existen registros disponibles",
            paginate: {
                first:      "Primera",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultima"
            }
        }
    });
    function log(data)
    {
        return console.log(data);
    }
</script>