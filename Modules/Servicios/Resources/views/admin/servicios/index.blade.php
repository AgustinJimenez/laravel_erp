@extends('layouts.master')

@section('content-header')
    <h1>
        Servicios
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.servicios.servicio.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Servicio
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">

                    <div class="col-md-2">
                            <label for="nombre" class="control-label" >Nombre:   </label> 
                            <input type="text" class="form-control input-sm" name="nombre" id="nombre" value="" >
                        </div>

                        <div class="col-md-2">
                            <label for="codigo" class="control-label" >Codigo:   </label> 
                            <input type="text" class="form-control input-sm" name="codigo" id="codigo" value="" >
                        </div >

                        <div class="col-md-2">
                            <label for="marca">Estado: </label>
                            <select class="form-control" id="estado" name="estado">
                                <option value='a' selected>--</option>
                                <option value='1'>Activo</option>
                                <option value='0' >Inactivo</option>
                            </select>
                        </div>






                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Precio Venta</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Precio Venta</th>
                            <th>Activo</th>
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
        <dd>{{ trans('servicios::servicios.title.create servicio') }}</dd>
    </dl>
@stop

@section('scripts')

    <style type="text/css">
        table.data-table  > thead > tr:nth-child(2)
        {
            display: none;
        }
        .data-table
        {
            width: 100%!important;
        }
    </style>
    

    <script type="text/javascript">
        var count=0;
        $(function () 
        {

            $("#nombre").on("keyup",function()
            {
                $("#0").val( $(this).val() ).keyup();

            });

            $("#codigo").on("keyup",function()
            {
                $("#1").val( $(this).val() ).keyup();
            });

            

            $("#estado").on("change",function()
            {
                if( $(this).val()==true )
                    var estado='1';
                else if( $(this).val()==false )
                    var estado='0';
                else
                    var estado='';

                $("#3").val(estado).keyup();
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
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax: '{!! route('admin.servicios.servicio.indexAjax') !!}',
                
                columns: 
                [
                    { data: 0, name: 'nombre' },
                    { data: 1, name: 'codigo' },
                    { data: 2, name: 'precio_venta' },
                    { data: 3, name: 'activo' },
                    { data: 5, name: 'acciones', orderable: false, searchable: false} 
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
                },
                
                initComplete: function () 
                {
                    this.api().columns().every(function () 
                    {

                        var column = this;

                        var input = document.createElement("input");
                        input.setAttribute("id",count );
                        count=count+1;
                        
                        $(input).appendTo($(column.footer()).empty()).on('keyup', function () 
                        {
                            var dato = $(this).val();
                            column.search(dato, false, false, true).draw();

                        });
                    });
                }

                
            });



            $('.data-table tbody').on('click', 'td.details-control', function () 
            {


                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) 
                {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else 
                {
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
            $('.data-table tfoot tr').appendTo('.data-table thead');

        
    
            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.servicios.servicio.create') ?>" }]});
        });
    </script>
@stop
