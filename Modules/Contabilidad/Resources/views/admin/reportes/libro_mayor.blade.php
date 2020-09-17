@extends('layouts.master')

@section('content-header')
    <h1>
        @if( isset($hay_cuenta) )
            {{ $titulo }}
        @else
            Libro Mayor
        @endif
    </h1>
    
@stop

@section('content')
    <style type="text/css">
        .to_historial{ cursor: pointer; cursor: hand; }
        .th_style{background-color:#3c8dbc; color:#fff}
    </style>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0; display: inline;">


                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('contabilidad::admin.reportes.partials-libro_mayor.libro-mayor-header')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- /.box-body -->
                    @include('contabilidad::admin.reportes.partials-libro_mayor.libro-mayor-table')
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
    @include('contabilidad::admin.reportes.partials-libro_mayor.libro-mayor-js')
@stop
