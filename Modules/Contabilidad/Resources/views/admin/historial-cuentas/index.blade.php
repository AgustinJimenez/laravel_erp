@extends('layouts.master')

@section('content-header')
    <h1>
        Cuenta: {{ $cuenta->codigo }} - {{ $cuenta->nombre }}
    </h1>
    
@stop

@section('content')
    <style type="text/css">
    .table-style
    {
        background-color:#3c8dbc; color:#fff;
        
    }
    #saldo_acumulado_div
    {
        margin-top: -10px;
    }

    #DataTables_Table_0_filter{display: none;}
        </style>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right">
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
  
                    @include('contabilidad::admin.historial-cuentas.partials.index-header')

                </div>
                <div class="box-body table-responsive" style="width: 100%;">

                    @include('contabilidad::admin.historial-cuentas.partials.index-table')

                </div>
            </div>
        </div>
    </div>

@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop


@section('scripts')
    @include('contabilidad::admin.historial-cuentas.partials.index-script')
@stop
