@extends('layouts.master')

@section('content-header')
    <h1>
        Balance
    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <!--
                    <a href="{{ route('admin.contabilidad.reportes.balance_pdf') }}" class="btn btn-danger btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-book"></i> {{ trans('Exportar a PDF') }}
                    </a>
                    -->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="data-table table table-bordered table-hover" id="data-table_1" style="width:100%;">
                                <thead>
                                    <th><h3>Activo</h3></th>
                                <tr>
                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    
                                        <tr>
                                            <td></td>

                                            <td></td>

                                            <td></td>
                                        </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                        <div class="col-md-4">
                            <table class="data-table table table-bordered table-hover" id="data-table_2" style="width:100%;">
                                <thead>
                                    <th><h3>Pasivo</h3></th>
                                <tr>

                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    
                                        <tr>
                                            <td></td>

                                            <td></td>

                                            <td></td>
                                        </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="data-table table table-bordered table-hover" id="data-table_3" style="width:100%;">
                                <thead>
                                    <th><h3>Patrimonio</h3></th>
                                <tr>

                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    
                                        <tr>
                                            <td></td>

                                            <td></td>

                                            <td></td>
                                        </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color:#3c8dbc; color:#fff">Codigo</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Nombre</th>
                                    <th style="background-color:#3c8dbc; color:#fff">Saldo</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
        <dd>{{ trans('contabilidad::cuentas.title.create cuenta') }}</dd>
    </dl>
@stop

@section('scripts')
    
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        var count=0;
        $(function () 
        {
            var table = $('#data-table_1').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",

                "deferRender": true,
                processing: true,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "iDisplayLength": 100,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.reportes.balance_activos') !!}',
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
            
                    }
                },
                columns: 
                [
                    { data: 'codigo', name: 'codigo' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'totales', name: 'totales'}
                    
                    //{ data: 'action', name: 'action', orderable: false, searchable: false}  
                ],
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "",
                    infoEmpty:      "",
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

            var table = $('#data-table_2').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",

                "deferRender": true,
                processing: true,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "iDisplayLength": 100,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.reportes.balance_pasivos') !!}',
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
            
                    }
                },
                columns: 
                [
                    { data: 'codigo', name: 'codigo' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'totales', name: 'totales'}
                    
                    //{ data: 'action', name: 'action', orderable: false, searchable: false}  
                ],

                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "",
                    infoEmpty:      "",
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

            var table = $('#data-table_3').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",

                "deferRender": true,
                processing: true,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "iDisplayLength": 100,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.reportes.balance_patrimonio') !!}',
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
            
                    }
                },
                columns: 
                [
                    { data: 'codigo', name: 'codigo' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'totales', name: 'totales'}
                    
                    //{ data: 'action', name: 'action', orderable: false, searchable: false}  
                ],

                 language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "",
                    infoEmpty:      "",
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

            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.contabilidad.cuenta.create') ?>" }]});
        });
    </script>
@stop
