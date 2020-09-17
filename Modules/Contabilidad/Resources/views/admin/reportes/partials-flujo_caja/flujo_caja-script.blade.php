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

        // $("#excel-button-export").click(function(event)
        // {
        //     $("#search-form-xls").submit();
        //     event.preventDefault(); 
        // });

      
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

    });
</script>
