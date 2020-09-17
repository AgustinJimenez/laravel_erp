{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
<?php $locale = locale(); ?>
<script type="text/javascript">
        $(document).ready(function() 
        {
            $("input[name=saldo_acumulado]").addClass('text-center');

            $("#form_report_excel").submit(function()
            {
                var fecha_inicio = $("#fecha_inicio");

                var fecha_fin = $("#fecha_fin");

                var fecha_inicio_excel = $("input[name=fecha_inicio_excel]");

                var fecha_fin_excel = $("input[name=fecha_fin_excel]");

                fecha_inicio_excel.val( fecha_inicio.val() );

                fecha_fin_excel.val( fecha_fin.val() );
            });

            $('#fecha_inicio').click(function()
            {
                $("#search-form").submit();
            });

            $('#fecha_fin').click(function()
            {
                $("#search-form").submit();
            });

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
                var fecha_inicio = $(this).val();

                $("#search-form").submit();
            });

            $("#fecha_fin").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_desde').click(function()
            {
                $('#fecha_inicio').val('');
                $("#search-form").submit();
                
            });

            $('#borrar_fecha_hasta').click(function()
            {
                $('#fecha_fin').val('');
                $("#search-form").submit();
            });

            $('#search-form').on('submit', function(e) 
            {
                table.draw();
                e.preventDefault();
            });

            var table = $('.data-table').DataTable(
            {
            /*  dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            */
                "deferRender": true,
                processing: true,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                 "iDisplayLength": 25,
                 "columnDefs": 
                [
                    { "width": "5%", "targets": 0 },
                    { "width": "10%", "targets": 1 },
                    { "width": "65%", "targets": 2 },
                    { "width": "10%", "targets": 3 },
                    { "width": "15%", "targets": 4 }
                ],
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.cuenta.historial_ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.cuenta_id = $('input[name=cuenta_id]').val();

                        d.fecha_inicio = $('#fecha_inicio').val();

                        d.fecha_fin = $('#fecha_fin').val();

                        d.saldo_acumulado = $("input[name=saldo_acumulado]").val();
                    },
                    "dataSrc": function ( json ) 
                    {
                        $("label[for=saldo_acumulado]").text('Saldo Acumulado hasta el '+json.fecha_inicio);

                        $("input[name=saldo_acumulado]").val(json.saldo_acumulado);

                        return json.data;
                    } 
                },
                columns: 
                [
                    { data: 'fecha', name: 'fecha' },
                    { data: 'operacion', name: 'operacion' },
                    { data: 'observacion', name: 'observacion' },
                    { data: 'debe', name: 'debe' },
                    { data: 'haber', name: 'haber' },
                    { data: 'saldo', name: 'saldo', orderable: false, searchable: false}
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


        });
</script>