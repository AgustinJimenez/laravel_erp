@extends('layouts.master')

@section('content-header')
    <h1>
        Seleccion de Productos
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Activo</th>
                            <th>Imagen</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td>
                                <div class="btn-group ">
                                    <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}" class="btn btn-primary btn-flat">Seleccionar</a>
                                    
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    {{ $producto->nombre }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    {{ $producto->categoria->nombre }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    {{ $producto->codigo }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    {{ $producto->stock }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    @if($producto->activo) SI @else NO @endif
                                </a>
                            </td>

                            <td style="">
                                <a href="{{ route('admin.productos.altabajaproducto.create', [$producto->id]) }}">
                                    <img src="{{ $producto->archivo }}" alt=""  class="img-thumbnail" style="width: 55px; height: 70px;">
                                </a>
                            </td>
                            
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Activo</th>
                            <th>Imagen</th>
                            
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
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.productos.producto.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 1, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@stop
