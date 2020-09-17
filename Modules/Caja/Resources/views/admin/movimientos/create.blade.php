@extends('layouts.master')

@section('content-header')
    <h1>
        Crear Movimiento de la Caja
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-header">
                   

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    @include('caja::admin.movimientos.partials.movimientos-fields')
                    </div>
                </div>
                <!-- /.box-body -->
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
    @include('caja::admin.movimientos.partials.movimientos-script')
    
    <?php $locale = locale(); ?>
    
@stop
