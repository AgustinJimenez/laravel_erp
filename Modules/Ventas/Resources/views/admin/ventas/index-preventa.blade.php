@extends('layouts.master')

@section('content-header')
    <h1>
        Preventas
    </h1>
    
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
                    <div class="row">

                    {!! Form::open(array('route' => ['admin.ventas.venta.indexAjax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-sm-2 col-xs-2">
                            <label for="razon_social" class="control-label" >Nro de Sobre:   </label>
                            <input type="text" class="form-control input-sm nro_seguimiento" name="nro_seguimiento" id="nro_seguimiento" value="" placeholder="Nro de Sobre">
                        </div>

                        <div class="col-sm-2 col-xs-2">
                            <label for="razon_social" class="control-label" >Cliente:   </label>
                            <input type="text" class="form-control input-sm cliente" name="cliente" id="cliente" value="" placeholder="Razon Social o Cedula">
                        </div>

                          <div class="col-sm-2 col-xs-2">
                            <table>
                                <tr>
                                    <td> 
                                        <label for="fecha_inicio_entrega" class="control-label" >F.I Entrega:   </label>
                                        <input type="text" class="form-control input-sm fecha_inicio_entrega" name="fecha_inicio_entrega" id="fecha_inicio_entrega" value="" placeholder="Fecha Inicio">
                                    </td>
                                    <td>
                                        <br>
                                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_inicio_entrega" style=""></i>
                                    </td>
                                </tr>
                            </table> 
                        </div >
                         <div class="col-sm-2 col-xs-2">
                            <table>
                                <tr>
                                    <td> 
                                        <label for="fecha_fin_entrega" class="control-label" >F.F Entrega:   </label>
                                        <input type="text" class="form-control input-sm fecha_fin_entrega" name="fecha_fin_entrega" id="fecha_fin_entrega" value="" placeholder="Fecha Fin">
                                    </td>
                                    <td>
                                        <br>
                                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_fin_entrega"></i>
                                    </td>
                                </tr>
                            </table> 
                        </div >

                            <div class="col-sm-2 col-xs-2" style="display: none;">
                                <label for="marca">Estado: </label>
                                <select class="form-control estado" id="estado" name="estado">
                                    <option value='preventa' selected>Preventa</option>
                                </select>
                            </div>

                            <div class="col-sm-2 col-xs-2">
                                {!! Form:: normalSelect('anulado', 'Anulado', $errors,[0=>'NO',1=>'SI'], null, ['id'=>'anulado'] ) !!}
                            </div>

                        <input type="submit" value="Filtrar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%; display: none;">

                        {!! Form::close() !!}
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead class=" btn-primary">
                        <tr>
                            <th>Nro de Sobre</th>
                            <th>Cliente</th>
                            <th>Fecha de Entrega</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
                            <th>Pendiente a Pagar</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody >
                        </tbody>
                        <tfoot class=" btn-primary">
                        <tr>
                            <th>Nro de Sobre</th>
                            <th>Cliente</th>
                            <th>Fecha de Entrega</th>
                            <th>Monto Total</th>
                            <th>Total Pagado</th>
                            <th>Pendiente a Pagar</th>
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
        <dd>{{ trans('ventas::ventas.title.create venta') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}

    
    <?php $locale = locale(); ?>

<!--==========================index_ajax======================-->

    <script type="text/javascript">

            $('#fecha_inicio_entrega').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $('#fecha_fin_entrega').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $("#fecha_inicio_entrega").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $("#fecha_fin_entrega").on("dp.change", function (e) 
            {
                $("#search-form").submit();
            });

            $('#borrar_fecha_inicio_entrega').click(function()
            {
                $('#fecha_inicio_entrega').val('');
                $("#search-form").submit();
                
            });

            $('#borrar_fecha_fin_entrega').click(function()
            {
                $('#fecha_fin_entrega').val('');
                $("#search-form").submit();
            });

            $("#nro_seguimiento").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#cliente").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#estado").on("change",function()
            {
                if( $(this).val()==true )
                    var estado='alta';
                else if( $(this).val()==false )
                    var estado='baja';
                else
                    var estado='';

                $("#search-form").submit();
            });

            $("#anulado").on("change",function()
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
                    url: '{!! route('admin.ventas.venta.indexAjax') !!}',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: function (e) 
                    {
                        e.nro_seguimiento = $('#nro_seguimiento').val(),
                        e.fecha_inicio_entrega = $('#fecha_inicio_entrega').val(),
                        e.fecha_entrega = $('#fecha_entrega').val(),
                        e.fecha_fin_entrega = $('#fecha_fin_entrega').val(),
                        e.cliente = $('#cliente').val(),
                        e.estado = $('#estado').val(),
                        e.anulado = $('#anulado').val()
                    }
                },
                columns: 
                [
                    { data: 'nro_seguimiento', name: 'nro_seguimiento' , orderable: false, searchable: false},
                    { data: 'razon_social', name: 'razon_social' , orderable: false, searchable: false},
                    { data: 'fecha_entrega', name: 'fecha_entrega' , orderable: false, searchable: false},
                    { data: 'monto_total', name: 'monto_total' , orderable: false, searchable: false},
                    { data: 'total_pagado', name: 'total_pagado' , orderable: false, searchable: false},
                    { data: 'monto_pagar', name: 'monto_pagar', orderable: false, searchable: false },
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
 
        
    </script>
<!--============================index_ajax=================================-->





@stop
