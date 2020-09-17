{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

<?php $locale = locale(); ?>
<script type="text/javascript">

    $.fn.dataTable.ext.errMode = 'none';
    
    var count=0;
    $(function () 
    {
        $(document).on('click', 'a.to_historial', function()
        {
            var fecha_desde = $("#fecha_desde");

            var fecha_hasta = $("#fecha_hasta");

            $(this).closest('tr').find('input[name=fecha_inicio_historial]').val( fecha_desde.val() );

            $(this).closest('tr').find('input[name=fecha_fin_historial]').val( fecha_hasta.val() );

            $(this).closest('tr').find('form').submit();
        });

        $("#form_report_xls").submit(function(event)
        {
            var fecha_desde = $("#fecha_desde");

            var fecha_hasta = $("#fecha_hasta");

            var codigo = $("#codigo");

            var tipo = $("#tipo");

            var nombre = $("#nombre");

            var fecha_inicio_xls = $("input[name=fecha_inicio_xls]");

            var fecha_fin_xls = $("input[name=fecha_fin_xls]");

            var codigo_xls = $("input[name=codigo_xls]");

            var tipo_xls = $("input[name=tipo_xls]");

            var nombre_xls = $("input[name=nombre_xls]");

            fecha_inicio_xls.val( fecha_desde.val() );

            fecha_fin_xls.val( fecha_hasta.val() );

            codigo_xls.val( codigo.val() );

            tipo_xls.val( tipo.val() );

            nombre_xls.val( nombre.val() );

            //event.preventDefault();
        });

        $('#fecha_desde').click(function()
        {
            $("#search-form").submit();
        });

        $('#fecha_hasta').click(function()
        {
            $("#search-form").submit();
        });

        $('#fecha_desde').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $('#fecha_hasta').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            //format: 'YYYY-MM-DD',
            locale: 'es'
        });

        $("#fecha_desde").on("dp.change", function (e) 
        {
            $("#search-form").submit();
        });

        $("#fecha_hasta").on("dp.change", function (e) 
        {
            $("#search-form").submit();
        });

        $('#borrar_fecha_desde').click(function()
        {
            $('#fecha_desde').val('');
            $("#search-form").submit();
            
        });

        $('#borrar_fecha_hasta').click(function()
        {
            $('#fecha_hasta').val('');
            $("#search-form").submit();
        });

        $("#codigo").on("keyup",function()
        {
            $("#search-form").submit();
        });

        $("#tipo").on("change",function()
        {
            $("#search-form").submit();
        });

        $("#nombre").on("keyup",function()
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
            "lengthChange": true,
             "iDisplayLength": 25,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "paginate": true,
            ajax: 
            {
                url: '{!! route('admin.contabilidad.reportes.libro_mayor_index') !!}',
                type: "GET",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: function (d) 
                {
                    @if( isset($hay_cuenta) )

                        d.cuenta_id = $('input[name=cuenta_id]').val();

                    @else
                        d.codigo = $('#codigo').val();

                        d.tipo_nombre = $('#tipo').val();

                        d.nombre = $('#nombre').val();  
                    @endif  

                    d.fecha_desde = $('#fecha_desde').val();

                    d.fecha_hasta = $('#fecha_hasta').val();

                                   
                }
            },
            columns: 
            [
                { data: 'codigo', name: 'codigo' },
                { data: 'tipo_nombre', name: 'tipo_nombre' },
                { data: 'nombre', name: 'nombre' },
                { data: 'debe', name: 'debe'},  
                { data: 'haber', name: 'haber'},
                { data: 'saldo', name: 'saldo'}
                //{ data: 'action', name: 'action', orderable: false, searchable: false}  
            ],
            language: {
                processing:     "Procesando...",
                search:         "Buscar",
                lengthMenu:     "Mostrar _MENU_ Elementos",
                info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
                //infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
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

        $(document).keypressAction({actions: [{ key: 'c', route: " {{ route('admin.contabilidad.cuenta.create') }} " }]});
    });
</script>