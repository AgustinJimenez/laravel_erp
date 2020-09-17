@extends('layouts.master')

@section('content-header')
    <h1>
        @if(isset($isOtros))
            Facturas de Otras Ventas
            <input type="hidden" name="isOtros" id="isOtros" value="1">
        @else
            Facturas de Ventas
            <input type="hidden" name="isOtros" id="isOtros" value="0">
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('ventas::facturaventas.title.facturaventas') }}</li>
    </ol>
@stop

@section('content')
    <style type="text/css">
        label, th, strong
        {
            font-size: 0.85em;
        }
    </style>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.ventas.facturaventa.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">

                            <div class="col-sm-2 col-xs-2">
                                {!! Form::normalInput('razon_social', 'Razon Social:', $errors, null, ['' => ''] ) !!} 
                            </div>

                            <div class="col-sm-2 col-xs-2">
                                {!! Form::normalInput('nro_factura', 'N° Factura:', $errors, null, ['' => ''] ) !!} 
                            </div>

                            <div class="col-sm-2 col-xs-2">
                                <table>
                                <tr>
                                    <td> 
                                        {!! Form::normalInput('fecha_inicio', 'Fecha Inicio:', $errors, null, ['placeholder' => 'Fecha Inicio'] ) !!} 
                                    </td>
                                    <td>
                                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_inicio"></i>
                                    </td>
                                </tr>
                                </table>
                            </div >

                            <div class="col-sm-2 col-xs-2">
                                <table>
                                <tr>
                                    <td> 
                                        {!! Form::normalInput('fecha_fin', 'Fecha Fin:', $errors, null, ['placeholder' => 'Fecha Fin'] ) !!} 
                                    </td>
                                    <td>
                                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_fin"></i>
                                    </td>
                                </tr>
                                </table>
                            </div >

                            <div class="col-sm-2 col-xs-2">
                                {!! Form::normalSelect('anulado', 'Anulado:', $errors, ['0'=>'No','1'=>'Si'], null) !!} 
                            </div>

                            <div class="col-sm-1 col-xs-1" >
                                {!! Form::label('', '') !!}
                                
                                <a href="{{ route('admin.ventas.facturaventa.generar_facturas_vacias') }}" class="btn btn-primary btn-flat">Anular Facturas</a>
                                
                            </div>
                            
                        </div>
                    {!! Form::close() !!}



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead class="btn-primary">
                        <tr>
                            <th>Fecha</th>
                            <th>Nro Factura</th>
                            <th>Razon Social</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
                            <th>Creado por</th>
                            <th>Ult Editado por </th>
                            <th data-sortable="false">{{ trans('Acciones') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="btn-primary">
                        <tr>
                            <th>Fecha</th>
                            <th>Nro Factura</th>
                            <th>Razon Social</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
                            <th>Creado por</th>
                            <th>Ult Editado por </th>
                            <th data-sortable="false">{{ trans('Acciones') }}</th>
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
        <dd>{{ trans('ventas::facturaventas.title.create facturaventa') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    <script type="text/javascript">
        var count=0;
        $(function () 
        {
            var input_fecha_inicio = 'input[name=fecha_inicio]';

            var input_fecha_fin = 'input[name=fecha_fin]';

            var input_razon_social = 'input[name=razon_social]';

            var select_anulado = "select[name=anulado]";

            var input_nro_factura = "input[name=nro_factura]";

            var operacion = $('#isOtros').val();

            //console.log("operacion =" ,operacion);

            $(input_fecha_inicio).datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $(input_fecha_fin).datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $(input_razon_social).on("keyup",function()
            {
                $("#search-form").submit();
            });

            $(input_nro_factura).on("keyup",function()
            {
                $("#search-form").submit();
            });
            
            $(input_fecha_inicio).on("dp.change",function()
            {
                $("#search-form").submit();
            });

            $(input_fecha_fin).on("dp.change",function()
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_inicio').click(function()
            {
                $(input_fecha_inicio).val('');
                $("#search-form").submit();
                
            });

            $('#borrar_fecha_fin').click(function()
            {
                $(input_fecha_fin).val('');
                $("#search-form").submit();
            });

            $(select_anulado).on("change",function()
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
                "order": [[ 1, "desc" ]],
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.ventas.facturaventa.index_ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.razon_social = $(input_razon_social).val();
                        e.fecha_inicio = $(input_fecha_inicio).val();
                        e.fecha_fin = $(input_fecha_fin).val();
                        e.anulado = $(select_anulado).val();
                        e.factura = $(input_nro_factura).val();
                        e.isOtros = operacion;
                        console.log(e.anulado);
                    }
                },
                columns: 
                [
                    { data: 'fecha', name: 'fecha' },
                    { data: 'nro_factura', name: 'nro_factura' },
                    { data: 'razon_social', name: 'razon_social' },
                    { data: 'monto_total', name: 'monto_total' },
                    { data: 'total_pagado', name: 'total_pagado' },
                    { data: 'creado_por', name: 'creado_por' },
                    { data: 'editado_por', name: 'editado_por' },
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
        });
    
        $( document ).ready(function() 
        {
            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.ventas.facturaventa.create') }}" }]});
        });
    </script>
@stop
