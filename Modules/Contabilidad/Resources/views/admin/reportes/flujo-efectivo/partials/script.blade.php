{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
{!! Theme::script('js/moment.js') !!}
{!! Theme::script('js/moment.es.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
<?php $locale = locale(); ?>
<script type="text/javascript">

    $.fn.dataTable.ext.errMode = 'none';

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

    $(document).on('click', 'a.to_detalles', function(event)
    {
        var fecha = $(this).text();

        fecha = fecha.split("/").reverse().join("-")+' 00:00:00' ;

        fecha = new Date(fecha)

        fecha = fecha.getTime()/1000;

        $(this).closest('tr').find('input[name=date]').val(fecha);

        $(this).closest('tr').find('form').submit();

        //event.preventDefault();
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

    function log(value)
    {
    	return console.log(value);
    }

    var table = $('.data-table').DataTable(
    {
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
            url: '{!! route('admin.contabilidad.reportes.flujo_efectivo_ajax') !!}',
            type: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: function (d) 
            {
               	d.fecha_inicio = $('#fecha_inicio').val();

               	d.fecha_fin = $('#fecha_fin').val();

                d.saldo_acumulado = $("input[name=saldo_acumulado]").val();
            },
            "dataSrc": function ( json ) 
            {
                $("input[name=saldo_acumulado]").val(json.saldo_acumulado);

                $("label[for=saldo_acumulado]").text('Saldo Acumulado hasta el '+json.fecha_inicio);

                return json.data;
            } 
        },
        columns: 
        [
            { data: 'fecha', name: 'fecha' },
            { data: 'debe', name: 'debe' },
            { data: 'haber', name: 'haber' },
            { data: 'saldo', name: 'saldo', orderable: false, searchable: false}
        ],
        language: 
        {
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


       
</script>