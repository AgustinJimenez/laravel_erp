@extends('layouts.master')

@section('content-header')
    <h1>
        Editar Nro de Factura - Compras
    </h1>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    

                    {!! Form::open(array('route' => ['admin.compras.compra.update_config_factura'],'method' => 'post', 'id' => 'search-form')) !!}
                        
                        <div class="row">
                            <div class="col-md-2">
                                {!! Form::normalInput('nro_factura_1', 'Nro Factura 1', $errors, $config, ['required' => '']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::normalInput('nro_factura_2', 'Nro Factura 2', $errors, $config, ['required' => '']) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::normalInput('nro_factura_ai', 'Nro Factura 3', $errors, $config, ['required' => '']) !!}
                            </div>

                        </div>    


                        {!!Form::submit('Actualizar', array('class' => 'search btn btn-primary btn-flat')) !!}

                    {!! Form::close() !!}
                    
                </div>
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
        <dd>{{ trans('compras::compras.title.create compra') }}</dd>
    </dl>
@stop

@section('scripts')
    {!! Theme::script('js/jquery.number.min.js') !!}
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $('#nro_factura_ai').number(true, 0, '', '');
        });
    </script>
@stop
