@extends('layouts.master')
@section('content-header')
    <h1>
        Seleccion
    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-body">
                    

                    <a href="{{ route('admin.compras.compra.create',['isProductos'])}}"><button type="button" class="btn btn-primary btn-lg btn-block" >Productos</button></a>
                    <a href="{{ route('admin.compras.compra.create')}}"><button type="button" class="btn btn-secondary btn-lg btn-block" href="{{ route('admin.ventas.venta.create') }}">Cristales/Servicios/Otros</button></a>
                   
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
    <script type="text/javascript">
        $( document ).ready(function() 
        {

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
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.ventas.venta.create') ?>" }]});
        });
    </script>
@stop
