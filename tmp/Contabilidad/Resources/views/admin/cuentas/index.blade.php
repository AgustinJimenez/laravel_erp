@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('contabilidad::cuentas.title.cuentas') }}
    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.contabilidad.cuenta.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('contabilidad::cuentas.button.create cuenta') }}
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
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Padre</th>
                            <th>Tiene Hijo</th>
                            <th>Activo</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($cuentas))
                            @foreach ($cuentas as $cuenta)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            {{ $cuenta->codigo }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            {{ $cuenta->tipo }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            {{ $cuenta->nombre }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            @if($cuenta->padre_nombre){{ $cuenta->padre_nombre->nombre }}@else sin padre @endif
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            @if($cuenta->tiene_hijo) SI @else NO @endif
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}">
                                            @if($cuenta->activo) SI @else NO @endif
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.contabilidad.cuenta.edit', [$cuenta->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.contabilidad.cuenta.destroy', [$cuenta->id]) }}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Padre</th>
                            <th>Tiene Hijo</th>
                            <th>Activo</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
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
        <dd>{{ trans('contabilidad::cuentas.title.create cuenta') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () 
        {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });


            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.contabilidad.cuenta.create') ?>" }]});
        });
    </script>
@stop
