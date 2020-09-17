@extends('layouts.master')

@section('content-header')
    <h1>
        Seleccion de Ejercicio Contable
    </h1>
    <ol class="breadcrumb">
       
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.contabilidad.ejercicio.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-4">
                            <h4><b> Ejercicio Contable Actual:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$ejercicio_actual}}</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <h4><b> Seleccionar otro Ejercicio:</b></h4>

                            {!! Form::normalSelect('ejercicio_seleccionado','', $errors, $ejercicios_disponibles) !!}
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{ route('admin.contabilidad.ejercicio.store')}}"><button type="submit" class="btn btn-primary btn-flat">{{"Aceptar"}}</button></a>
                        
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('dashboard.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
