@extends('layouts.master')

@section('content-header')
    <h1>
        Reporte de Ventas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.ventas.venta.index') }}">{{ trans('ventas::facturaventas.title.facturaventas') }}</a></li>
        <li class="active">{{ trans('ventas::facturaventas.title.create facturaventa') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    
@stop

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
            <!--******************reporte_filters.blade.php******************************************-->
                @include('ventas::admin.ventas.partials.reporte_filters')
            <!--******************reporte_filters.blade.php******************************************-->
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************factura-fileds.blade.php**************************************************-->
                            @include('ventas::admin.ventas.partials.reporte-field')
<!--**************************factura-fileds.blade.php**************************************************-->
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
<!--***************script-factura-venta.blade.php*****************************************-->
    @include('ventas::admin.ventas.partials.reporte-script')
 <!--**************script-factura-venta.blade.php*****************************************-->
@stop
