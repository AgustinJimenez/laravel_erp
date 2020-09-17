@extends('layouts.master')

@section('content-header')
    <h1>
        Empleados
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.empleados.empleado.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Empleado
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.empleados.empleado.indexAjax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-md-2">
                            <label for="apellido" class="control-label" >Nombre:   </label> 
                            <input type="text" class="form-control input-sm" name="nombre" id="nombre" value="" >
                        </div >

                        <div class="col-md-2">
                            <label for="nombre" class="control-label" >Apellido:   </label> 
                            <input type="text" class="form-control input-sm" name="apellido" id="apellido" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="cedula" class="control-label" >Cedula:   </label> 
                            <input type="text" class="form-control input-sm" name="cedula" id="cedula" value="" >
                        </div >

                        <div class="col-md-2">
                            <label for="marca">Estado: </label>
                            <select class="form-control" id="estado" name="activo">
                                <option value='' selected>--</option>
                                <option value='1'>Activo</option>
                                <option value='0' >Inactivo</option>
                            </select>
                        </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover" id="tablaEmpleados">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Cargo</th>
                                <th>RUC</th>
                                <th>Activo</th>
                                <th>Acciones</th>
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
                                <td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Cargo</th>
                                <th>RUC</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
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
        <dd>{{ trans('empleados::empleados.title.create empleado') }}</dd>
    </dl>
@stop

@section('scripts')
    


    <script type="text/javascript">
        $(function () 
        {
            $("#nombre").on("keyup",function()
            {
                $("#search-form").submit();

            });

            $("#apellido").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#cedula").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#estado").on("change",function()
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
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax: 
                 {
                    url: '{!! route('admin.empleados.empleado.indexAjax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.nombre = $('#nombre').val();
                        e.apellido = $('#apellido').val();
                        e.cedula = $('#cedula').val();
                        e.activo = $('#estado').val();
                    }
                },
                columns: 
                [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'apellido' , name: 'apellido' },
                    { data: 'cedula', name: 'cedula' },
                    { data: 'cargo', name: 'cargo' },
                    { data: 'ruc', name: 'ruc' },
                    { data: 'activo', name: 'activo' },
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

            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.empleados.empleado.create') ?>" }]});
        });
    </script>
@stop
