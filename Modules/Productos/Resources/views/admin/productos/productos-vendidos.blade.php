@extends('layouts.master')

@section('content-header')
    <h1>
        Productos vendidos
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('productos::admin.productos.partials.productos-vendidos-filters')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('productos::admin.productos.partials.productos-vendidos-fields')
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
        <dd>{{ trans('productos::productos.title.create producto') }}</dd>
    </dl>
@stop

@section('scripts')
    @include('productos::admin.productos.partials.productos-vendidos-script')
@stop
