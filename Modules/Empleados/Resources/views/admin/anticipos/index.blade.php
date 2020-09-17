@extends('layouts.master')

@section('content-header')
    <h1>
        Anticipos
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.empleados.anticipos.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> Crear Anticipo
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('empleados::admin.anticipos.partials.index-header')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('empleados::admin.anticipos.partials.index-table')
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('empleados::admin.anticipos.partials.index-delete-confirmation-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')

@stop

@section('scripts')
    @include('empleados::admin.anticipos.partials.index-script')
@stop
