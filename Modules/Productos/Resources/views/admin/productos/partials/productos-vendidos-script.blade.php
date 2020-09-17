{!! Theme::script('js/moment.js') !!}

{!! Theme::script('js/moment.es.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}

{!! Theme::script('js/ekko-lightbox.min.js') !!}

{!! Theme::script('js/ekko-lightbox.min.js.map') !!}

{!! Theme::style('css/ekko-lightbox.min.css') !!}

{!! Theme::style('css/ekko-lightbox.min.css.map') !!}

<style type="text/css">

    .alignRight { text-align: right; }

</style>

<script type="text/javascript">


	$(document).ready(function()
	{
    
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var year = d.getFullYear();
        var today = day+'/'+month+'/'+year; 
        var aux_today = (day- (day-1))+'/'+month+'/'+year;
        
        
      
        $('#fecha_inicio').val(aux_today);
        $('#fecha_fin').val(today);

        $('#fecha_inicio').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            locale: 'es'
        });

        $('#fecha_fin').datetimepicker(
        {
            format: 'DD/MM/YYYY',
            locale: 'es'
        });

       $('select[name=categoria]').change(function()
        {
            var value = $('select[name=categoria]').val();
            $("select[name=categoria]").val(value);
            $("#search-form").submit();
            //$("#anho").val(value);
        });

       $('select[name=marca]').change(function()
        {
            var value = $('select[name=marca]').val();
            $("select[name=marca]").val(value);
            $("#search-form").submit();
            //$("#anho").val(value);
        });

       $('input[name=producto]').on("keyup", function () 
        {
            var value = $('select[name=producto]').val();
            $('select[name=producto]').val( value );

            $("#search-form").submit();
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

        var table = $('#tabla_productos').DataTable(
        {
            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            "deferRender": true,
            processing: true,
            serverSide: true,
            "paginate": true,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            ajax: 
            {
                url: '{!! route('admin.productos.producto.productos_vendidos_ajax') !!}',
                type: "POST",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: function (e) 
                {
                    e.fecha_inicio = $('#fecha_inicio').val();
                    e.fecha_fin = $('#fecha_fin').val();
                    e.categoria = $('select[name=categoria]').val();
                    e.marca = $('select[name=marca]').val();
                    e.productos = $('input[name=producto]').val();
                }
            },


            columns: 
            [
                // { data: 'fecha' , name: 'fecha' },
                { data: 'categoria', name: 'categoria' },
                { data: 'marca', name: 'marca' },
                { data: 'producto_nombre', name: 'producto_nombre' },
                { data: 'total_venta', name: 'total_venta'},
                { data: 'total_costo', name: 'total_costo'},
                { data: 'ganancia', name: 'ganancia'}
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

	$(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.productos.producto.index') }}" }]});

</script>