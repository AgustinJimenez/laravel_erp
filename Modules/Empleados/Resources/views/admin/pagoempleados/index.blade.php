@extends('layouts.master')

@section('content-header')
    <h1>
        Pago Empleado
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('empleados::pagoempleados.title.pagoempleados') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    
                    <a href="{{ route('admin.empleados.pagoempleado.seleccionEmpleado') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Pago
                    </a>
                    
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.empleados.pagoempleado.indexAjax'],'method' => 'post', 'id' => 'search-form')) !!}
                        
                         <div class="col-md-2 ">
                            <label for="fecha" class="control-label" >Empleado:  </label> 
                            <input type="text" class="form-control input-sm" name="nombre" id="nombre" value="" style="">
                        </div>

                        <div class="col-md-2 ">
                            <table>
                                <tr>
                                    <td><label for="fecha" class="control-label" >Fecha Inicio:   </label> 
                                    <input type="text" class="form-control input-sm" name="fecha_inicio" id="fecha_inicio" value="" style=""></td>
                                   <td><br><button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_inicio" style=""><i class="fa fa-trash" style=""></i></button></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-2">
                            <table>
                                <tr>
                                    <td><label for="fecha" class="control-label" >Fecha Inicio:   </label> 
                                    <input type="text" class="form-control input-sm" name="fecha_fin" id="fecha_fin" value="" style=""></td>
                                   <td><br><button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_fin" style=""><i class="fa fa-trash" style=""></i></button></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-1">
                            {!! Form::normalSelect('anulado', 'Anulado', $errors, [0 => "NO", 1 => "SI"], null, ['id' => "anulado"]) !!}
                        </div>

                        

                        

                        <input type="submit" value="Filtrar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%;display: none;ne;">
                    {!! Form::close() !!}


                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Anulado</th>
                            <th>Acciones</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        
                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Anulado</th>
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
        <dd>{{ trans('empleados::pagoempleados.title.create pagoempleado') }}</dd>
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
        var count=0;
        $(function () 
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
                $('#search-form').submit();
            });

            $("#fecha_fin").on("dp.change", function (e) 
            {
                $('#search-form').submit();
            });

            $('#borrar_fecha_inicio').click(function()
            {
                $('#fecha_inicio').val('');
                $('#search-form').submit();
                
            });

            $('#borrar_fecha_fin').click(function()
            {
                $('#fecha_fin').val('');
                $('#search-form').submit();
            });

            $("#producto").on("keyup",function()
            {
                $('#search-form').submit();
            });

            $("#nombre").on("keyup",function()
            {
                // alert('da');
                $('#search-form').submit();
            });     
            $("#anulado").on("change",function()
            {
                console.log("anulado changed");
                $('#search-form').submit();
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
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax: 
                 {
                    url: '{!! route('admin.empleados.pagoempleado.indexAjax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.empleado = $('#nombre').val();

                        d.fecha_inicio = $('#fecha_inicio').val();

                        d.fecha_fin = $('#fecha_fin').val();

                        d.anulado = $('#anulado').val();
                    }
                },
                columns: 
                [
                    { data: 'fecha', name: 'fecha' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'apellido', name: 'apellido' },
                    { data: 'usuario', name: 'usuario' },
                    { data: 'anulado', name: 'anulado' },
                    { data: 'accion', name: 'accion', orderable: false, searchable: false}
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

            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.productos.altabajaproducto.create') ?>" }]});
        });
    </script>
@stop
