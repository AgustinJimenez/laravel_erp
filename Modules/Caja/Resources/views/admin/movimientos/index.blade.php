@extends('layouts.master')

@section('content-header')
    <h1>
        Movimientos de la Caja-@if($caja->created_at != '0000-00-00 00:00:00')<strong>Apertura: </strong>{{ $caja->created_at_format }} @endif @if($caja->cierre != '0000-00-00 00:00:00') <strong>Cierre:</strong> {{ $caja->cierre_format_timestamp }} @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('caja::cajas.title.cajas') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.caja.caja.create_movimiento') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear un Movimiento 
                    </a>
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
                                <th>Fecha Hora</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Motivo</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($caja) && count($caja->movimientos)>0  )
                                @foreach($caja->movimientos as $key => $movimiento)
                                    <tr>
                                        <td>{{ $movimiento->format('fecha_hora', 'datetime') }}</td>
                                        <td>{{ $movimiento->usuario }}</td>
                                        <td>{{ $movimiento->format('monto_fixed', 'number') }}</td>
                                        <td>{{ $movimiento->motivo }}</td>
                                        <td>{{ $movimiento->tipo }}</td>
                                        
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Fecha Hora</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Motivo</th>
                                <th>Tipo</th>
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
        <dd>{{ trans('caja::cajas.title.create caja') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.ventas.detalleventa.create') }}" }]});
        $(function () 
        {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
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
    </script>
@stop
