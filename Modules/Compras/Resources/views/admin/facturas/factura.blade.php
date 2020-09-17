@extends('layouts.master')

@section('content-header')
    <h1>
        @if($compra->anulado)
            Detalle de Compra Anulada
        @else
            Detalle de Compra
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.compras.compra.index') }}">{{ trans('ventas::facturaventas.title.facturaventas') }}</a></li>
        <li class="active">{{ trans('compras::facturaventas.title.create facturaventa') }}</li>
    </ol>
@stop

@section('styles')
  
@stop

@section('content')

    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                             <div class="row">
         <div class="col-md-9">
        </div>
        <div class="col-md-3">
            @if($compra->usuario_create)
                {!! Form::label('usuario_create', 'Creado por:') !!}
                {{ $compra->usuario_apellido_nombre('create') }}
            @endif

            @if($compra->usuario_edit)
                {!! Form::label('usuario_edit', 'Ult Editado por:') !!}
                {{ $compra->usuario_apellido_nombre('edit') }}
            @endif
        </div>
    </div>
                            @include('compras::admin.facturas.partials.factura-cabecera')
                        </div>
                    @endforeach

                    <div class="box-footer">
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    
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
    @include('compras::admin.facturas.partials.factura-script')
@stop
