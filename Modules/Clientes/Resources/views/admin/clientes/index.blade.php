@extends('layouts.master')

@section('content-header')
    <h1>
        Clientes
    </h1>
    <ol class="breadcrumb">
        
        <li class="active">{{-- trans('clientes::clientes.title.clientes') --}}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">

                    <a href="{{ route('admin.clientes.cliente.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Cliente
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
     
                    {!! Form::open(array('route' => ['admin.clientes.cliente.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors, null, ['id' => 'razon_social']) !!}

                            </div>

                            <div class="col-md-2">
                                {!! Form::normalInput('cedula', 'Cedula', $errors, null, ['id' => 'cedula']) !!}
                            </div >

                            <div class="col-md-2">
                                {!! Form::normalInput('ruc', 'RUC', $errors, null, ['id' => 'ruc']) !!}
                            </div >

                            <div class="col-md-2">
                                {!! Form:: normalSelect('estado', 'Estado', $errors, [''=>'--','1'=>'Activo','0'=>'Inactivo'], null) !!}
                            </div>
                            @if( $permisos->has('Ver boton de cargar clientes desde excel') and $permisos->get('Ver boton de cargar clientes desde excel') )
                            <div class="col-md-2">
                                <br>
                                <a href="{{ route('admin.clientes.cliente.upload_cliente_xls') }}" class="btn btn-success">Cargar Clientes Desde Excel</a>
                            </div>
                            @endif
                            
                            @if( $permisos->has('Ver boton de descargar ejemplo excel') and $permisos->get('Ver boton de descargar ejemplo excel') )
                            <div class="col-md-2">
                                <br>
                                <a href="{{ route('admin.clientes.cliente.descargar_ejemplo') }}" class="btn btn-primary btn-flat">Descargar Ejemplo Excel</a>
                            </div>
                            @endif
                        </div>
                    {!! Form::close() !!}

                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover" id="tablaClientes" >
                            <thead>
                            <tr>
                                <th>Nombre o Razon Social</th>
                                <th>Cedula</th>
                                <th>RUC</th>
                                <th>Telefono</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nombre o Razon Social</th>
                                <th>Cedula</th>
                                <th>RUC</th>
                                <th>Telefono</th>
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
    @include('clientes::admin.clientes.partials.confirmation-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('clientes::clientes.title.create cliente') }}</dd>
    </dl>
@stop

@section('scripts')

    <script type="text/javascript">


        $(document).ready(function()
        {
            $("body").on('click', '.button-eliminar', function()
            {
                var ventas = parseInt($(this).attr('ventas'));
                var url = $(this).attr('route');
                $("#confirmation-modal-form").attr('action', url);
                var mensaje = "";
                if(ventas)
                {
                    mensaje = "No se puede eliminar al cliente, ya esta asociado a alguna venta";
                    $("#confirmation-modal-form").hide();
                }
                else
                {
                    mensaje = "¿Estás seguro que quieres eliminar este registro?";
                    $("#confirmation-modal-form").show();
                }

                $(".modal-body").html( mensaje );

                $("#confirmation-modal").modal('show');
            });

            $("input[name=razon_social]").keyup(function()
            {

                $("#search-form").submit();
            });

            $("#cedula").on("keyup",function()
            {

                $("#search-form").submit();
            });

            $("#ruc").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("select[name=estado]").on("change",function()
            {
                $("#search-form").submit();
            });

            $('#search-form').submit(function(e) 
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
                'responsive': true,
                processing: true,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                 {
                    url: '{!! route('admin.clientes.cliente.index_ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.razon_social = $('#razon_social').val();
                        e.cedula = $('#cedula').val();
                        e.ruc = $('#ruc').val();
                        e.estado = $("select[name=estado]").val();
                    }
                },
                columns: 
                [
                    { data: 'razon_social', name: 'razon_social' },
                    { data: 'cedula', name: 'cedula' },
                    { data: 'ruc', name: 'ruc' },
                    { data: 'telefono', name: 'telefono' },
                    { data: 'activo', name: 'activo' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false} 
                ], 

                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
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
@stop
