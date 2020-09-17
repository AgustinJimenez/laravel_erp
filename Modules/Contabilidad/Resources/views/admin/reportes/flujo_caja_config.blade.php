@extends('layouts.master')

@section('content-header')
    <h1>
        Flujo de Efectivo:
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ trans('Reporte de Gastos ') }}</a></li>
        <li class="active">{{ trans('Reporte de Gastos ') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">

                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************factura-fileds.blade.php**************************************************-->
                    {!! Form::open(['route' => ['admin.contabilidad.reportes.flujo_caja'], 'method' => 'post', 'id' => 'search-form']) !!}

                            <div class="box-header">
                                <div class="col-md-2">

                                {!! Form:: normalSelect('year', 'Seleccione el Año', $errors, $años) !!}
                                
                                </div >
                            </div>
                       
<!--**************************factura-fileds.blade.php**************************************************-->
                        </div>
                    @endforeach

                    <div class="box-footer ">
                    <button class="btn btn-primary btn-flat" type="submit" value=""> Ver Reporte</button>
                        {{-- <a class="btn btn-primary btn-flat" href="{{ route('admin.contabilidad.reportes.ingreso_egreso')}}"> Ver Reportes </button> --}}
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('dashboard.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>

                    </div>
                     {!! Form::close() !!} 
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
    <script type="text/javascript">
        
    $(document).ready(function() 
    {

         $("#anho").val($('select[name=year]').val());
      
        $('select[name=year]').change(function()
        {
            var value = $('select[name=year]').val();
            $("#anho").val(value);
        });
    

    });
        
    </script>
@stop