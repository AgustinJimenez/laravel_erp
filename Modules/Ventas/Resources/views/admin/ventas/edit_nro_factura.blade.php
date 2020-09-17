@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Editar N° de Factura') }}
    </h1>
    
@stop

@section('styles')

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
                        {!! Form::open(array('route' => ['admin.ventas.facturaventa.update_nro_factura'],'method' => 'post')) !!}
                            @if ($configs)
                                @foreach ($configs as $key => $config)
                                    <tr>
                                    
                                        <div class="col-sm-3 {!! $errors->first('valor.'.$key, 'has-error') !!}">
                                            <?php 
                                                $identificador=ucwords(str_replace('_', ' ', $config->identificador));

                                            ?>
                                            <label>{{ $identificador }}</label>
                                            <input type="text"  class="form-control col-sm-3" name="valor[]" id="valor" value="{{ $config->valor }}" style=""> 
                                            <div style="position: relative; width: 100%;">
                                                {!! $errors->first('valor.'.$key, '<p style="font-size: 10px">:message</p>') !!}
                                            </div>

                                            <br>

                                            <div style="display: none;">
                                                <input type="text"  class="form-control input-sm" name="etiqueta[]" id="etiqueta" value="{{ $config->identificador }}" style=""> 
                                            </div>
                                            <br>
                                        </div>
                                    
                                    </tr>
                                @endforeach
                            @endif
                            <br>
                            <input type="submit" value="Guardar" class="search btn btn-primary btn-flat" id="filtro" style=" margin-left: 2%;display: ;">
                        {!! Form::close() !!}
                        
                    
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
        <dd></dd>
    </dl>
@stop

@section('scripts')
    
    
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            localStorage.clear();
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
        });
    </script>
@stop
