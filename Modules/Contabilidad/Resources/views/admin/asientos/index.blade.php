@extends('layouts.master')

@section('content-header')
    <h1>
        Asientos
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('contabilidad::asientos.title.asientos') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.contabilidad.asiento.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('Crear Asiento') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                     {!! Form::open(array('route' => ['admin.contabilidad.asiento.index_ajax_asientos'],'method' => 'get', 'id' => 'search-form')) !!}

                        <div class="col-md-2">
                            
                            {!! Form::normalInput('observacion', 'Buscar por Observacion:', $errors) !!}
                        </div>

                        <div class="col-md-2">
                            <label for="fecha_inicio" class="control-label" >Desde Fecha:   </label>
                            <input type="text" class="form-control input-sm fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="" >
                            
                        </div >

                        <div class="col-md-2">
                            <label for="fecha_inicio" class="control-label" >Hasta Fecha:   </label>
                            <input type="text" class="form-control input-sm fecha_fin" name="fecha_fin" id="fecha_fin" value="" >
                        </div >
                        <div class="col-md-2">
                            {!! Form::normalInput('operacion', 'Operacion: ', $errors, null) !!}
                        </div>

                     {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive" style="width: 100%;">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Observacion</th>
                                <th>Operacion</th>
                                <th>Creado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                               
                                <th>Fecha</th>
                                <th>Observacion</th>
                                <th>Operacion</th>
                                <th>Creado por</th>
                                <th>Acciones</th>
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
        <dd>{{ trans('contabilidad::asientos.title.create asiento') }}</dd>
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
            
        });
    </script>
   
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        var count=0;
        $(function () 
        {

            var dateNow = new Date();
            var day = dateNow.getDate()-(dateNow.getDate()-1);
            var month = dateNow.getMonth();
            var year = dateNow.getFullYear();
            
            var primer = new Date(year, month, day)

            $('#fecha_inicio').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate:primer
            });

            $('#fecha_fin').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate:dateNow
            });
           
            var primer = new Date('YYYY/MM/01');
            $('#fecha_fin').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate:dateNow
            });

            $('#fecha_inicio').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //defaultDate:dateNow
                locale: 'es'
            });

            $("#fecha_inicio").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#fecha_fin').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $("#fecha_fin").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $("#observacion").on("keyup",function()
            {
                $("#search-form").submit();
            });
            $("#operacion").on("keyup",function()
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
                "columnDefs": 
                [
                    { "width": "5%", "targets": 0 },
                    { "width": "55%", "targets": 1 },
                    { "width": "15%", "targets": 2 },
                    { "width": "10%", "targets": 3 },
                    { "width": "15%", "targets": 4 }
                ],
                "lengthChange": true,
                "sort": true,
                "iDisplayLength": 50,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.asiento.index_ajax_asientos') !!}',
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.observacion = $('#observacion').val();
                        d.fecha_inicio = $('#fecha_inicio').val();
                        d.fecha_fin = $('#fecha_fin').val();
                        d.operacion = $('#operacion').val();
                    }
                },
                columns: 
                [
                    
                    { data: 'fecha', name: 'fecha' },
                    { data: 'observacion', name: 'observacion' },
                    { data: 'operacion', name: 'operacion' },
                    { data: 'usuario_create', name: 'usuario_create' },
                    { data: 'action', name: 'action', orderable: false, searchable: false} 
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

            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.contabilidad.cuenta.create') }}" }]});
        });
    </script>
@stop
