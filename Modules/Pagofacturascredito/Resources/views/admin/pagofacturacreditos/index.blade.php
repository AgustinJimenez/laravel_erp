@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pagofacturascredito::pagofacturacreditos.title.pagofacturacreditos') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pagofacturascredito::pagofacturacreditos.title.pagofacturacreditos') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.pagofacturascredito.pagofacturacredito.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        
                        <div class="col-md-2">
                            {!! Form::normalInput('fecha_inicio','Fecha Inicio', $errors ) !!}
                            {!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}
                        </div >

                        <div class="col-md-2">
                            {!! Form::normalInput('fecha_fin','Fecha Fin', $errors ) !!}
                            {!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}
                        </div>

                    {!! Form::close() !!}

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('pagofacturascredito::pagofacturacreditos.title.create pagofacturacredito') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    <script type="text/javascript">
        $( document ).ready(function() 
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

            $("#fecha_inicio").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_inicio').click(function()
            {
                $('#fecha_inicio').val('');
                $("#search-form").submit();
                
            });

            $("#fecha_fin").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_fin').click(function()
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
                    url: '{!! route('admin.pagofacturascredito.pagofacturacredito.index_ajax') !!}',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: function (e) 
                    {
                        e.fecha_inicio = $('#fecha_inicio').val();
                        e.fecha_fin = $('#fecha_fin').val();
                    }
                },
                columns: 
                [
                    { data: 'fecha', name: 'fecha' },
                    { data: 'monto', name: 'monto' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false}
                ], 
            });

            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.pagofacturascredito.pagofacturacredito.create') }}" }]});
        });
    </script>
    <?php $locale = locale(); ?>
    
@stop
