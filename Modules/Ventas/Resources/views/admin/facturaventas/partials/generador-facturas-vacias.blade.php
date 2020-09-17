@extends('layouts.master')

@section('content-header')
    <h1>
        Anular Facturas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.ventas.facturaventa.index') }}">{{ trans('ventas::facturaventas.title.facturaventas') }}</a></li>
        <li class="active">{{ trans('ventas::facturaventas.title.create facturaventa') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    <style type="text/css">
        .ajust-label
        {
            margin-top: 2.5%;
            margin-right: -3.5%;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.ventas.facturaventa.crear_facturas_vacias'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************************view******************************************************************************-->
                            <div class="row">
                                <div class="col-md-1 ajust-label">
                                    {!!Form::label('nro_base', $nro_base) !!}
                                </div>

                                <div class="col-md-1 ">
                                    {!! Form::normalInput('nro_inicio', 'Desde', $errors, (object)['nro_inicio' => str_pad($nro_incre, 3, '0', STR_PAD_LEFT)], ['readonly'=>'']) !!} 
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-1 ajust-label">
                                    {!!Form::label('nro_base', $nro_base) !!}
                                </div>

                                <div class="col-md-1">
                                    {!! Form::normalInput('nro_fin', 'Hasta', $errors, (object)['nro_fin' => str_pad($nro_incre, 3, '0', STR_PAD_LEFT),'required'=>'required']) !!} 
                                </div>
                            </div>
<!--***************************************view*****************************************************************************-->
                        </div>
                    @endforeach
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Anular Facturas</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.ventas.facturaventa.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
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
    {!! Theme::script('js/jquery.number.min.js') !!}
    <script type="text/javascript">
        $('#nro_inicio').number(true, 0, '', '');
        $('#nro_fin').number(true, 0, '', '');
        
    </script>
@stop
