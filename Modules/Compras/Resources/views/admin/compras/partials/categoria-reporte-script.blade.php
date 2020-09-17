{!! Theme::script('js/moment.js') !!}

{!! Theme::script('js/moment.es.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}

<!--************************************FILE-EXPORT***********************-->
{!! Theme::script('js/data_table_file_export/1dataTables.buttons.min.js') !!}
{!! Theme::script('js/data_table_file_export/6buttons.html5.min.js') !!}
{!! Theme::script('js/data_table_file_export/7buttons.print.min.js') !!}
{!! Theme::script('js/data_table_file_export/2buttons.flash.min.js') !!}
{!! Theme::script('js/data_table_file_export/4pdfmake.min.js') !!}
{!! Theme::script('js/data_table_file_export/5vfs_fonts.js') !!}
{!! Theme::script('js/data_table_file_export/3jszip.min.js') !!}
{!! Theme::style('js/data_table_file_export/8buttons.dataTables.min.css') !!}
<!--************************************FILE-EXPORT************************-->

<script type="text/javascript">
	$(document).ready(function() 
    {
		$('#fecha_inicio').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $('#fecha_fin').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $("#excel-button-export").click(function(event)
        {
            $("#search-form-xls").submit();
            event.preventDefault(); 
        });

        $("#fecha_inicio").on("dp.change", function (e) 
        {
            $("#fecha_inicio2").val( $(this).val() );

            $("#search-form").submit();
        });

        $("#fecha_fin").on("dp.change", function (e) 
        {
            $("#fecha_fin2").val( $(this).val() );

            $("#search-form").submit();
        });

        $('#borrar_fecha_inicio').click(function()
        {
            $("#fecha_inicio2").val( '' );
            $('#fecha_inicio').val('');
            $("#search-form").submit();
            
        });

        $('#borrar_fecha_fin').click(function()
        {
            $("#fecha_fin2").val( '' );
            $('#fecha_fin').val('');
            $("#search-form").submit();
        });

        $('#search-form').on('submit', function(e) 
        {
            table.draw();
            e.preventDefault();
        });
    
        
        var table = $('#table').DataTable(
        {
            
            //dom: 'Bfrtip',
            //buttons: ['excel', 'pdf'],
            "deferRender": true,
            processing: true,
            serverSide: true,
            "paginate": true,
            "order": [[ 0, "desc" ]],
            "lengthChange": true,
            "lengthMenu": [[25, 50, 100], [25, 50, 100]],
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            ajax: 
             {
                url: '{!! route('admin.compras.compra.categorias_reporte_gastos_ajax') !!}',
                 headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type: "POST",
                data: function (e) 
                {
                    //console.log(e);
                    e.fecha_inicio = $('#fecha_inicio').val();
                    e.fecha_fin = $('#fecha_fin').val();
                },
                "dataSrc": function ( json ) 
                {
                    $("#sum_monto_total").text(json.sum_monto_total);

                    $("#sum_total_pagado").text(json.sum_total_pagado);

                    return json.data;
                }
            },
            columns: 
            [
                { data: 'nro_factura', name: 'nro_factura' },
                { data: 'tipo', name: 'tipo' },
                { data: 'razon_social', name: 'razon_social' },
                { data: 'fecha', name: 'fecha' },
                { data: 'monto_total', name: 'monto_total' },
                { data: 'total_pagado', name: 'total_pagado' }
            ],

            language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
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
        

    });
</script>
