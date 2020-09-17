@extends('layouts.master')

@section('content-header')
    <h1>
        Cajas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('caja::cajas.title.cajas') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.caja.caja.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{'Crear Caja'}}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.caja.caja.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}

                        <div class="col-md-2">
                            {!! Form::normalInput('usuario','Usuario', $errors ) !!}
                        </div>
                        
                        <div class="col-md-2">
                            <table>
                            <tr>
                            <td>{!! Form::normalInput('fecha_inicio','Fecha Inicio', $errors ) !!}</td>
                            <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
                            </tr>
                            </table>
                        </div >

                        <div class="col-md-2">
                            <table>
                            <tr>
                            <td>{!! Form::normalInput('fecha_fin','Fecha Fin', $errors ) !!}</td>
                            <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
                            </tr>
                            </table>
                        </div>

                        <div class="col-md-2">
                            {!! Form:: normalSelect('activo', 'Estado', $errors, ['1' =>'Activo', '0' => 'Inactivo']) !!}
                        </div>

                    {!! Form::close() !!}

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Usuario</th>
                            <th>Monto Inicial</th>
                            <th>Activo</th>
                            <th data-sortable="false">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Fecha Apertura</th>
                            <th>Fecha Cierre</th>
                            <th>Usuario</th>
                            <th>Monto Inicial</th>
                            <th>Activo</th>
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
        <dd>{{ trans('caja::cajas.title.create caja') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    <?php $locale = locale(); ?>
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

            $("#usuario").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("select[name=activo]").on("change",function()
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
                    url: '{!! route('admin.caja.caja.index_ajax') !!}',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: function (e) 
                    {
                        e.fecha_inicio = $('#fecha_inicio').val();
                        e.fecha_fin = $('#fecha_fin').val();
                        e.usuario = $('#usuario').val();
                        e.activo = $('select[name=activo]').val();
                    }
                },
                columns: 
                [
                    { data: 'created_at', name: 'created_at' },
                    { data: 'cierre', name: 'cierre' },
                    { data: 'usuario', name: 'usuario' },
                    { data: 'monto_inicial', name: 'monto_inicial' },
                    { data: 'activo', name: 'activo' },
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
                
            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.caja.caja.create') }}" }]});

        });
    </script>
@stop
