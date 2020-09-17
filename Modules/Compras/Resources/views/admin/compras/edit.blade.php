    <?php                                                $debug = false;

if($debug)
    $debug = 'display:none;';
else
    $debug = '';
?>
@extends('layouts.master')

@section('content-header')
    <h1>
        @if( $isProducto == 0 && $isCristal == 0 && $isServicio == 0 && $isOtro == 0)
        <?php $isProducto = 1;?>
    @endif

        @if($isProducto)
            Detalle de Producto
        @elseif($isCristal)
            Detalle de Cristales
        @elseif($isServicio)
            Detalle de Pago-Servicios
        @elseif($isOtro)
            Detalle de Compras-Otros
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.compras.compra.index') }}">{{ trans('compras::compras.title.compras') }}</a></li>
        <li class="active">{{ trans('compras::compras.title.edit compra') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    <?php $isCompra = 1;?>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                @include('proveedores::admin.proveedors.modal_create_proveedor')
            </div>
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        {!! Form::open(['route' => ['admin.compras.compra.update', $compra->id], 'method' => 'put']) !!}
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('compras::admin.compras.partials.cabecera')
                        <div class="box-footer">
                            
                        </div>
                        {!! Form::close() !!}
                    @endforeach
                    </div>
                </div> {{-- end nav-tabs-custom --}}
            </div>
        </div>
    </div>
    
    <!--*************************************************Modal Pago*****************************************************************************************-->


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
