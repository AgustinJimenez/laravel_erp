@extends('layouts.master')

@section('content-header')
    <h1>
        Reporte de Gastos por Concepto
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ trans('Reporte de Gastos') }}</a></li>
        <li class="active">{{ trans('Reporte de Gastos') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
<!--******************************************reporte_filters.blade.php******************************************-->
                @include('compras::admin.compras.partials.reporte_filters')
<!--******************************************reporte_filters.blade.php******************************************-->
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************factura-fileds.blade.php**************************************************-->
                            @include('compras::admin.compras.partials.reporte-field')
<!--**************************factura-fileds.blade.php**************************************************-->
                        </div>
                    @endforeach

                    <div class="box-footer">
                       {{--  <button type="submit" class="btn btn-primary btn-flat">Generar Reporte</button> --}}
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.compras.compra.reporte_gastos_performance')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    @include('compras::admin.compras.partials.reporte-script')
 <!--**************script-factura-venta.blade.php*****************************************-->
@stop
