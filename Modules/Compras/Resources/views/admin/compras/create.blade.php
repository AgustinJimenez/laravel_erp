    <?php                                                $debug = false;

if($debug)
    $debug = '';
else
    $debug = 'display:none;';
    
?>
@extends('layouts.master')

@section('content-header')
    <h1>
    @if( $isProducto == 0 && $isCristal == 0 && $isServicio == 0 && $isOtro == 0)
        <?php $isProducto = 1;?>
    @endif

        @if($isProducto)
            Compra de Productos
        @elseif($isCristal)
            Compra de Cristales
        @elseif($isServicio)
            Pago-Servicios
        @elseif($isOtro)
            Compras-Otros
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.compras.compra.index') }}">{{ trans('compras::compras.title.compras') }}</a></li>
        <li class="active">{{ trans('compras::compras.title.create compra') }}</li>
    </ol>
@stop

@section('styles')
    
    <style type="text/css">
    #cke_1_top
    {
        display: none;
    }

    #cke_1_bottom
    {
        display: none;
    }
    /*cke_51 ui-id-16*/
    .input_white
    {
        border:0px; 
        font-size:14pt; 
        background-color:white;
    }
    label[for="monto_total_iva"]{display: none;}
    label[for="proveedor_id"]{display: none;}
    </style>
@stop

@section('content')
    <?php $isCompra = 1;?>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">

                            <div class="box-body cabecera">
                                <div class="col-md-3">
                                    @include('proveedores::admin.proveedors.modal_create_proveedor')
                                </div>
                                {!! Form::open(['route' => ['admin.compras.compra.store'], 'method' => 'post']) !!}

                                    @include('compras::admin.compras.partials.cabecera')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
                                
<!--*************************************************Modal_Pago*****************************************************************************************-->
    
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    
@stop
