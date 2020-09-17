@extends('layouts.master')

@section('content-header')
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <h2>
                Ventas
            </h2>
        </div>
        <div class="col-sm-2 col-xs-2">
            <br>
            <a style="width: 80%;" href="{{ route('admin.ventas.venta.reporte') }}" class="btn btn-primary btn-flat" id="excel-button-export">Reportes</a>
        </div>
    </div>
@stop

@section('content')
    <style type="text/css">
        label, th, strong
        {
            font-size: 0.85em;
        }
    </style>
    <div class="row">

        <div class="col-sm-12">
                            
            <div class="box box-primary">


                <div class="box-header">
                    <br>
                    <div class="row" >

                        {!! Form::open(array('route' => ['admin.ventas.venta.indexAjax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-sm-2 col-xs-2">
                            <label for="nro_sobre" class="control-label" >Nro de Sobre:   </label>
                            <input type="text" class="form-control input-sm nro_seguimiento" name="nro_seguimiento" id="nro_seguimiento" value="" placeholder="Nro de Sobre">
                        </div>

                         <div class="col-sm-2 col-xs-2">
                            <label for="nro_factura" class="control-label" >Nro de Factura:   </label>
                            <input type="text" class="form-control input-sm nro_seguimiento" name="nro_factura" id="nro_factura" value="" placeholder="Nro de Factura">
                        </div>

                        <div class="col-sm-2 col-xs-2">
                            <label for="cliente" class="control-label" >Cliente:   </label>
                            <input type="text" class="form-control input-sm cliente" name="cliente" id="cliente" value="" placeholder="Razon Social o Cedula" >
                        </div>
                
                        <div class="col-sm-2 col-xs-2">
                            <table>
                                <tr>
                                    <td> 
                                        <label for="fecha_inicio" class="control-label" >F.I Venta:   </label>
                                        <input type="text" class="form-control input-sm fecha_inicio" name="fecha_inicio" id="fecha_inicio" value="" placeholder="Fecha Inicio">
                                    </td>
                                    <td>
                                        <br>
                                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_inicio"></i>
                                    </td>
                                </tr>
                            </table> 
                        </div >

                        <div class="col-sm-2 col-xs-2">
                            <table>
                                <tr>
                                    <td> 
                                        <label for="fecha_fin" class="control-label" >F.F Venta:   </label>
                                        <input type="text" class="form-control input-sm fecha_fin" name="fecha_fin" id="fecha_fin" value="" placeholder="Fecha Fin">
                                    </td>
                                    <td>
                                        <br>
                                            <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_fin"></i>
                                        </td>
                                </tr>
                            </table> 
                        </div >

                        <div class="col-sm-2 col-xs-2"" style="display: none;">
                            <label for="marca">Estado: </label>
                            <select class="form-control estado" id="estado" name="estado">
                                <option value='terminado' selected>Terminado</option>
                            </select>
                        </div>

                        <div class="col-sm-2 col-xs-2">
                            {!! Form:: normalSelect('anulado', 'Anulado', $errors,[0=>'NO',1=>'SI'], null, ['id'=>'anulado', 'class' => 'form-control'] ) !!}
                        </div>

                        

                        <input type="submit" value="Filtrar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%; display: none;">

                        {!! Form::close() !!}
                    </div>


                </div>
                 

                <!-- /.box-header -->
                <div class="box-body table-responsive" style=" overflow: auto; " >

                    <table class="data-table table table-bordered table-hover">
                        <thead class=" btn-primary">
                            <tr>
                                <th>Nro de Sobre</th>
                                <th>Nro de Factura</th>
                                <th>Cliente</th>
                                <th>Fecha de Venta</th>
                                <th>Fecha de Entrega</th>
                                <th>Monto Total</th>
                                <th data-sortable="false">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                        <tfoot class=" btn-primary">
                            <tr>
                                <th>Nro de Sobre</th>
                                <th>Nro de Factura</th>
                                <th>Cliente</th>
                                <th>Fecha de Venta</th>
                                <th>Fecha de Entrega</th>
                                <th>Monto Total</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                   
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

            $("#nro_seguimiento").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#cliente").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#nro_factura").on("keyup",function()
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
                scrollY: "auto",
                scrollX: false,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                
                "columnDefs": 
                [
                    { "width": "13.5%", "targets": 0 },
                    { "width": "12.5%", "targets": 1 },
                    { "width": "29%", "targets": 2 },
                    { "width": "12.5%", "targets": 3 },
                    { "width": "12.5%", "targets": 4 },
                    { "width": "9.5%", "targets": 5 },
                    { "width": "10.5%", "targets": 6 },
                ],
                
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
                        e.nro_seguimiento = $('#nro_seguimiento').val();
                        e.fecha_inicio = $('#fecha_inicio').val();
                        e.fecha_fin = $('#fecha_fin').val();
                        e.cliente = $('#cliente').val();
                        e.estado = $('#estado').val();
                        e.anulado = $('#anulado').val();
                        e.factura = $("#nro_factura").val();
                    }
                },
                columns: 
                [
                    { data: 'nro_seguimiento', name: 'nro_seguimiento' , orderable: false, searchable: false},
                    { data: 'nro_factura', name: 'nro_factura' , orderable: false, searchable: false},
                    { data: 'razon_social', name: 'razon_social' , orderable: false, searchable: false},
                    { data: 'fecha_venta', name: 'fecha_venta' , orderable: false, searchable: false},
                    { data: 'fecha_entrega', name: 'fecha_entrega' , orderable: false, searchable: false},
                    { data: 'monto_total', name: 'monto_total' , orderable: false, searchable: false},
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
