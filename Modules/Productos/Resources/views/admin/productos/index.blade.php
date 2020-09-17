@extends('layouts.master')

@section('content-header')
    <h1>
    @if( isset($stock_minimo) )
        Productos con stock crítico
    @else
        Productos
    @endif
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.productos.producto.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear un Producto
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.productos.producto.index_ajax'],'method' => 'post', 'id' => 'search-form')) !!}

                        <div class="col-md-2">
                            {!! Form::normalInput('codigo', 'Codigo:', $errors, null) !!} 
                        </div >
                        <div class="col-md-3 select-categorias"></div>
                        <div class="col-md-2">
                            {!! Form::normalInput('marca', 'Marca:', $errors, null) !!} 
                        </div >

                        <div class="col-md-2">
                            {!! Form::normalInput('nombreProducto', 'Nombre de Producto:', $errors, null) !!} 
                        </div >

                        <div class="col-md-2">
                            <label for="">Estado: </label>
                            <select class="form-control" id="estado" name="estado">
                                <option value='' selected>--</option>
                                <option value='1'>Activo</option>
                                <option value='0' >Inactivo</option>
                            </select>
                        </div>
        <!--
                        <div class="col-md-2">
                            <BR>
                            <a href="{{ route("admin.productos.producto.cargar_producto") }}" class="btn btn-success"><STRONG>CARGAR PRODUCTOS</STRONG></a>
                        </div>
        -->
                        @if( isset($stock_minimo) )
                            {!! Form::hidden('stock_minimo', $stock_minimo, array('id' => 'stock_minimo')) !!}
                        @endif
                    {!! Form::close() !!}

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="data-table table table-bordered table-hover" id="tablaProductos" width="100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Nombre</th>
                                <th>Stock</th> 
                                @if( isset($stock_minimo) ) 
                                <th>Stock Minimo</th> 
                                @endif
                                <th>Precio Venta</th>
                                <th>Activo</th>
                                <!--
                                <th>Imagen</th>
                                -->
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>@if( isset($stock_minimo) ) <td></td> @endif   
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Stock</th>@if( isset($stock_minimo) ) <th>Stock Minimo</th> @endif
                            <th>Precio Venta</th>
                            <th>Activo</th>
                            <!--
                            <th>Imagen</th>
                            -->
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
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
        <dd>{{ trans('productos::productos.title.create producto') }}</dd>
    </dl>
@stop

@section('scripts')

    {!! Theme::script('js/ekko-lightbox.min.js') !!}

    {!! Theme::script('js/ekko-lightbox.min.js.map') !!}

    {!! Theme::style('css/ekko-lightbox.min.css') !!}

    {!! Theme::style('css/ekko-lightbox.min.css.map') !!}


    <script type="text/javascript">
        $.fn.dataTable.ext.errMode = 'none'; 
        $(function () 
        {

            $(document).on("change", "select[name=categoria]" ,function()
            {
                $("#search-form").submit();
            });

            $("#marca").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#codigo").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#nombreProducto").on("keyup",function()
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
                "iDisplayLength": 100,
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax: 
                 {
                    url: '{!! route('admin.productos.producto.index_ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.categoria = $("select[name=categoria]").val();
                        e.marca = $('#marca').val();
                        e.codigo = $('#codigo').val();
                        e.nombre = $('#nombreProducto').val();
                        e.activo = $('#estado').val();
                        @if( isset($stock_minimo) )
                            e.stock_minimo = $('#stock_minimo').val();
                        @endif
                    },
                    "dataSrc": function ( json ) 
                    {

                        if( $(".select-categorias").html() == '' )
                        {
                            var element_content = '{!!  php_to_js( 

                                                        '<label for="categoria" class="control-label" >Categoria:</label>
                                                            <select name="categoria" class="form-control">
                                                                <option value="">--</option>'
                                                    ) 
                                                    !!}';

                            element_content = element_content.replace(/(?:\r\n|\r|\n)/g, '');

                            json.categorias.forEach(function(item, index)
                            {
                                element_content += '<option value="' + item.id + '">' + item.nombre + '    codigo: ' + item.codigo + '</option>';
                            });

                            element_content += '</select>';

                            $(".select-categorias").html(element_content);
                        }
                        

                        return json.data;
                    }  
                },
                columns: 
                [
                    { data: 'codigo', name: 'codigo' },
                    { data: 'categoria' , name: 'categoria' },
                    { data: 'marca', name: 'marca' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'stock', name: 'stock' },
                    @if( isset($stock_minimo) )
                    { data: 'stock_minimo', name: 'stock_minimo' },
                    @endif  
                    { data: 'precio_venta', name: 'precio_venta'},
                    { data: 'activo', name: 'activo'},
                    /*
                    { data: 'archivo', name: 'archivo', orderable: false, searchable: false},
                    */
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

<?php 
        function php_to_js( $code ){return trim(preg_replace('/\s\s+/', ' ', htmlspecialchars_decode($code)));}
?>

            $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.productos.producto.create') }}" }]});
        });

    </script>
@stop
