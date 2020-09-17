@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('Editar N° de Sobre') }}
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
                        @if(isset($venta_id))
                            {!! Form::open(array('route' => ['admin.ventas.venta.update_nro_seguimiento'],'method' => 'post')) !!}
                                <div class="row"> 
                                    <div class="col-md-2">
                                        <label class="mylabel"> N° de Sobre :</label>
                                        <input class="form-control" type="" name="nro_seguimiento" value="{{$nro_seguimiento}}"> 
                                        <input class="form-control" type="hidden" name="venta_id" value="{{$venta_id}}"> 
                                    </div>
                                </div>
                                <br>
                                <input type="submit" value="Guardar" class="search btn btn-primary btn-flat">
                            {!! Form::close() !!}
                        @else
                            @if($nro_seguimiento)
                            {!! Form::open(array('route' => ['admin.ventas.venta.update_nro_seguimiento'],'method' => 'post')) !!}
                                <div class="row">
                                    <div class="col-md-2">
                                        {!! Form::normalInput('nro_1', 'Numero 1', $errors, $nro_seguimiento) !!} 
                                    </div>

                                    <div class="col-md-2">
                                        {!! Form::normalInput('nro_2', 'Numero 2', $errors, $nro_seguimiento) !!} 
                                    </div>
                                    <div class="col-md-2" style="display: none;">
                                        {!! Form::normalInput('id', 'id', $errors, $nro_seguimiento) !!} 
                                    </div>
                                </div>
                                
                                
                                <input type="submit" value="Guardar" class="search btn btn-primary btn-flat">
                            {!! Form::close() !!}
                            @endif
                        @endif
                        

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
        
    {!! Theme::script('js/jquery.number.min.js') !!}    
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $('#nro_1').number(true, 0, '', '');
            $('#nro_2').number(true, 0, '', '');
            localStorage.clear();
        });
    </script>
    <?php $locale = locale(); ?>
    
@stop
