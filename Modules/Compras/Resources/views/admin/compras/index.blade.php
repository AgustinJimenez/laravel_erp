@extends('layouts.master')

@section('content-header')
    <h1>

        @if( isset($pendiente)?$pendiente:null )
            Facturas Pendientes
        @else
            Compras
        @endif

    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">

                    {!! Form::open(array('route' => ['admin.compras.compra.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-md-2">
                            <label for="nro_factura" class="control-label" >Nro de Factura:   </label>
                            <input type="text" class="form-control input-sm nro_seguimiento" name="nro_factura" id="nro_factura" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="proveedor" class="control-label" >Proveedor:   </label>
                            <input type="text" class="form-control input-sm cliente" name="proveedor" id="proveedor" value="" >
                        </div>
                            <div class="col-md-2">
                            <table>
                            <tr>
                            <td><label for="fecha_inicio" class="control-label" >Fecha Inicio:   </label>
                            <input type="text" class="form-control input-sm fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="" ></td>
                            <td><br><button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_inicio" style=""><i class="fa fa-trash" style=""></i></button></td>
                            </tr>
                            </table>
                            </div>

                            <div class="col-md-2">
                            <table>
                            <tr>
                            <td><label for="fecha_fin" class="control-label" >Fecha Fin:   </label>
                            <input type="text" class="form-control input-sm fecha_fin" name="fecha_fin" id="fecha_fin" value="" ></td>
                            <td><br><button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_fin" style=""><i class="fa fa-trash" style=""></i></button></td>
                            </tr>
                            </table>
                            </div>
                
                        {{-- <div class="col-md-2">
                            <label for="fecha_inicio" class="control-label" >Fecha Inicio:   </label>
                            <input type="text" class="form-control input-sm fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="" >
                            <button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_inicio" style=""><i class="fa fa-trash" style=""></i></button>
                        </div > --}}
{{-- 
                        <div class="col-md-2">
                            <label for="fecha_fin" class="control-label" >Fecha Fin:   </label>
                            <input type="text" class="form-control input-sm fecha_fin" name="fecha_fin" id="fecha_fin" value="" >
                            <button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_fin" style=""><i class="fa fa-trash" style=""></i></button>
                        </div> --}}

                        <div class="col-md-2">
                            {!! Form:: normalSelect('anulado', 'Anulado', $errors, ['0' => 'NO', '1' => 'SI'], null) !!}
                        </div>
                        @if(isset($pendiente)?$pendiente:null)
                            {!! Form::hidden('pendiente', 1, array('id' => 'pendiente')) !!}
                        @else
                            {!! Form::hidden('pendiente', 0, array('id' => 'pendiente')) !!}
                        @endif

                        <input type="submit" value="Filtrar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%; display: none;">

                    {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nro Factura</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total IVA</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
                            <th>Anulado</th>
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
                                    <td></td>
                                </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nro Factura</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total IVA</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
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
        <dd>{{ trans('compras::compras.title.create compra') }}</dd>
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
            // $('.data-table').DataTable( {
                
            // });
        });
    </script>
    <?php $locale = locale(); ?>

    <script type="text/javascript">
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
                $("#search-form").submit();
            });

            $("#fecha_fin").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_inicio').click(function()
            {
                $('#fecha_inicio').val('');
                $("#search-form").submit();
                
            });

            $('#borrar_fecha_fin').click(function()
            {
                $('#fecha_fin').val('');
                $("#search-form").submit();
            });

            $("#nro_factura").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#proveedor").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $('select[name=anulado]').change(function()
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
                    url: '{!! route('admin.compras.compra.index_ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.nro_factura = $('#nro_factura').val();

                        d.fecha_inicio = $('#fecha_inicio').val();

                        d.fecha_fin = $('#fecha_fin').val();

                        d.proveedor = $('#proveedor').val();

                        d.estado = $('#estado').val();

                        d.pendiente = $('#pendiente').val();

                        d.anulado = $('select[name=anulado]').val();
                    }
                },
                columns: 
                [
                    { data: 'nro_factura', name: 'nro_factura' },
                    { data: 'razon_social', name: 'proveedores__proveedors.razon_social' },
                    { data: 'fecha', name: 'fecha' },
                    { data: 'total_iva', name: 'total_iva' },
                    { data: 'monto_total', name: 'monto_total' },
                    { data: 'total_pagado', name: 'total_pagado' },
                    { data: 'anulado', name: 'anulado' },
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

            $(document).keypressAction({actions: [{ key: 'c', route: "{{route('admin.compras.compra.create') }}" }]});
        });
    </script>
@stop
