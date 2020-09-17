@extends('layouts.master')

@section('content-header')
    <h1>
        Categorias de Productos
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('styles')
    <style type="text/css">

        table.data-table  > thead > tr:nth-child(2)
        {
            display: none;
        }

    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.productos.categoriaproducto.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Categoria
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    <div class="col-md-2">
                        <label for="categoria" class="control-label" >Nombre de Categoria:   </label> 
                        <input type="text" class="form-control input-sm" name="categoria" id="categoria" value="" >
                    </div>





                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($categoriaproductos)): ?>
                        <?php foreach ($categoriaproductos as $categoriaproducto): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.productos.categoriaproducto.edit', [$categoriaproducto->id]) }}">
                                    {{ $categoriaproducto->codigo }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.categoriaproducto.edit', [$categoriaproducto->id]) }}">
                                    {{ $categoriaproducto->nombre }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('admin.productos.categoriaproducto.edit', [$categoriaproducto->id]) }}">
                                    {!! $categoriaproducto->descripcion !!}
                                </a>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.productos.categoriaproducto.edit', [$categoriaproducto->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.productos.categoriaproducto.destroy', [$categoriaproducto->id]) }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
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
        <dd>{{ trans('productos::categoriaproductos.title.create categoriaproducto') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() 
        {


            $("#categoria").on("keyup",function()
            {
                $("[id='Nombre']").val( $(this).val() );

                $("[id='Nombre']").keyup();
            });

   
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () 
        {
            var table = $('.data-table').DataTable({
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
            $('.data-table tfoot th').each( function () 
            {
                var title = $(this).text();
                $(this).html( '<input type="text" id="'+(title.trim())+'" class="inputDatatable" placeholder="Search '+title+'" />' );
            });
            table.columns().every( function () 
            {
                var that = this;
     
                $( 'input', that.footer() ).on( 'keyup change', function () 
                {
                    if ( that.search() !== this.value ) 
                    {
                        that
                        .search( this.value )
                        .draw();
                    }
                });
            });
            $('.data-table tfoot tr').appendTo('.data-table thead');





            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.productos.categoriaproducto.create') ?>" }]});
        });
    </script>
@stop
