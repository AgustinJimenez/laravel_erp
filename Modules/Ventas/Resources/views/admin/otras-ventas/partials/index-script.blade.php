{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
<?php $locale = locale(); ?>
<script type="text/javascript">

    $.fn.dataTable.ext.errMode = 'none';

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

    $("#fecha_inicio").on("dp.change", function (e) 
    {
        $("#search-form").submit();
    });

    $("#fecha_fin").on("dp.change", function (e) 
    {
        $("#search-form").submit();
    });

    $('#borrar_fecha_inicio').click(function()
    {
        $('#fecha_inicio').val('');
        $("#search-form").submit();
    });

    $('#borrar_fecha_fin').click(function()
    {
        $('#fecha_fin').val('');
        $("#search-form").submit();
    });

    $("#razon_social").on("keyup",function()
    {
        $("#search-form").submit();
    });

    $("#nro_factura").on("keyup",function()
    {
        $("#search-form").submit();
    });

    $("#anulado").on("change",function()
    {
        $("#search-form").submit();
    });

    $('#search-form').on('submit', function(e) 
    {
        table.draw();
        e.preventDefault();
    });
    
    var table = $('.data-table').DataTable(
    {
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
        "<'row'<'col-xs-12't>>"+
        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        "deferRender": true,
        processing: true,
        serverSide: true,
        "paginate": true,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "filter": true,
        "sort": true,
        "info": true,
        "autoWidth": true,
        ajax: 
        {
            url: '{!! route('admin.ventas.otras_ventas.index_ajax') !!}',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            type: "POST",
            data: function (e) 
            {
                e.fecha_inicio = $('#fecha_inicio').val();
                e.fecha_fin = $('#fecha_fin').val();
                e.razon_social = $('#razon_social').val();
                e.anulado = $('#anulado').val();
                e.nro_factura = $("#nro_factura").val();
            }
        },
        columns: 
        [
            { data: 'fecha_venta', name: 'fecha_venta' },
            { data: 'nro_factura', name: 'nro_factura' },
            { data: 'razon_social', name: 'razon_social' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'monto_total', name: 'monto_total' },
            { data: 'total_pagado', name: 'total_pagado' },
            { data: 'creado_por', name: 'creado_por' },
            { data: 'anulado', name: 'anulado' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false}
        ], 

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
</script>