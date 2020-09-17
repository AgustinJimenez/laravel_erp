@extends('layouts.master')

@section('content-header')
    <h1>
        Proveedores
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.proveedores.proveedor.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Proveedor
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.proveedores.proveedor.indexAjax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-md-2">
                            <label for="razon_social" class="control-label" >Nombre o Razon Social:   </label> 
                            <input type="text" class="form-control input-sm" name="razon_social" id="razon_social" value="" >
                        </div >

                        <div class="col-md-2">
                            <label for="ruc" class="control-label" >RUC:   </label> 
                            <input type="text" class="form-control input-sm" name="ruc" id="ruc" value="" >
                        </div >
                    {!! Form::close() !!}
 
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nombre o Razon Social</th>
                                <th>RUC</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Contacto</th>
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
                            </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nombre o Razon Social</th>
                                <th>RUC</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Contacto</th>
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
        <dd>{{ trans('proveedores::proveedors.title.create proveedor') }}</dd>
    </dl>
@stop

@section('scripts')

    <?php $locale = locale(); ?>
    <script type="text/javascript">
        var count=0;
        $(function () 
        {

            $("#razon_social").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#ruc").on("keyup",function()
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
                    url: '{!! route('admin.proveedores.proveedor.indexAjax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.razon_social = $('#razon_social').val();
                        e.ruc = $('#ruc').val();
                    }
                },
                columns: 
                [
                    { data: 'razon_social', name: 'razon_social' },
                    { data: 'ruc', name: 'ruc' },
                    { data: 'direccion', name: 'direccion' },
                    { data: 'telefono', name: 'telefono' },
                    { data: 'contacto', name: 'contacto' },
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

            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.proveedores.proveedor.create') ?>" }]});
        });
    </script>
@stop
