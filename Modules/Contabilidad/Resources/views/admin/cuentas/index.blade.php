@extends('layouts.master')

@section('content-header')
    <h1>
        Cuentas
    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.contabilidad.cuenta.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('Crear Cuenta') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    {!! Form::open(array('route' => ['admin.contabilidad.cuenta.index_ajax_filter'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="col-md-2">
                            <label for="razon_social" class="control-label" >Codigo:   </label>
                            <input type="text" class="form-control input-sm codigo" name="codigo" id="codigo" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="marca">Tipo: </label>
                            <select class="form-control tipo" id="tipo" name="tipo">
                                <option value='' selected>--</option>
                                @foreach($tipos as $tipo)
                                    <option value='{{ $tipo->nombre }}'>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="razon_social" class="control-label" >Nombre:   </label>
                            <input type="text" class="form-control input-sm nombre" name="nombre" id="nombre" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="razon_social" class="control-label" >Padre:   </label>
                            <input type="text" class="form-control input-sm padre" name="padre" id="padre" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="marca">Tiene Hijo: </label>
                            <select class="form-control tiene_hijo" id="tiene_hijo" name="tiene_hijo">
                                <option value='' selected>--</option>
                                <option value='1'>SI</option>
                                <option value='0' >NO</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="marca">Estado: </label>
                            <select class="form-control estado" id="estado" name="estado">
                                <option value='' >--</option>
                                <option value='1' selected>Activo</option>
                                <option value='0' >Inactivo</option>
                            </select>
                        </div>

                    {!! Form::close() !!}

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
                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td></td>
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
    
    @include('contabilidad::admin.cuentas.partials.delete-modal-cuenta')
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
            $("#codigo").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#tipo").on("change",function()
            {
                $("#search-form").submit();
            });

            $("#nombre").on("keyup",function()
            {
                $("#search-form").submit();
            });

            $("#padre").on("keyup",function()
            {
                $("#search-form").submit();
            });

            
            $("#tiene_hijo").on("change",function()
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
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "lengthMenu": [[25, 50, 100], [25, 50, 100]],
                "iDisplayLength": 50,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "paginate": true,
                ajax: 
                {
                    url: '{!! route('admin.contabilidad.cuenta.index_ajax_filter') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (d) 
                    {
                        d.codigo = $('#codigo').val();

                        d.tipo_nombre = $('#tipo').val();

                        d.nombre = $('#nombre').val();

                        d.padre = $('#padre').val();

                        d.tiene_hijo = $('#tiene_hijo').val();

                        d.activo = $('#estado').val();

                    }
                },
                columns: 
                [
                    { data: 'codigo', name: 'codigo' },
                    { data: 'tipo_nombre', name: 'tipo_nombre' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'padre', name: 'padre' },
                    { data: 'tiene_hijo', name: 'tiene_hijo' },
                    { data: 'activo', name: 'activo' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                  
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

            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.contabilidad.cuenta.create') ?>" }]});
        });
    </script>
@stop
