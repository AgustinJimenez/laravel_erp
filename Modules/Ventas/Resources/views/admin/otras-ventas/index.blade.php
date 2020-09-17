@extends('layouts.master')

@section('content-header')
    <h1>
        Otras Ventas
    </h1>
    
@stop

@section('content')
    <style type="text/css">
        .table-th-style
        {
            background-color:#3c8dbc; color:#fff;
            
        }
    
    #DataTables_Table_0_filter{/*display: none;*/}
    label, th, strong
        {
            font-size: 0.85em;
        }
        </style>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right">
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
  
                    @include('ventas::admin.otras-ventas.partials.index-header')

                </div>
                <div class="box-body table-responsive">

                    @include('ventas::admin.otras-ventas.partials.index-table')

                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop


@section('scripts')
    @include('ventas::admin.otras-ventas.partials.index-script')
@stop
