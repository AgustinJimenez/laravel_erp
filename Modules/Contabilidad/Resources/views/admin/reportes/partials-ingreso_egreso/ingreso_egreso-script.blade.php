{!! Theme::script('js/moment.js') !!}

{!! Theme::script('js/moment.es.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}

{!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

{!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}


<script type="text/javascript">
	$(document).ready(function() 
    {

        $("#excel-button-export").click(function(event)
        {
            $("#search-form-xls").submit();
            event.preventDefault(); 
        });

      
        $('select[name=year]').change(function()
        {
            table.ajax.reload();
            var value = $(this).val();
            //alert(  ); 
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
                url: '{!! route('admin.contabilidad.reportes.ingreso_egreso_ajax') !!}',
                 headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type: "POST",
                data: function (e) 
                {
    
                    e.year = $('select[name=year]').val();
  
                },
                // "dataSrc": function ( json ) 
                // {
                //     $("#sum_total_pagado_salarios").text(json.sum_total_pagado_salarios);

                //     $("#sum_total_pagado").text(json.sum_total_pagado);

                //     $("#sum_total_pagado_ips").text(json.sum_total_pagado_ips);

                //     return json.data;
                // }
            },
           
            columns: 
            [
                { data: 'fecha', name: 'fecha' },
                { data: 'ingresos', name: 'ingresos' },
                { data: 'egresos', name: 'egresos' },
                { data: 'diferencia', name: 'diferencia' }
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
        

    });
</script>
