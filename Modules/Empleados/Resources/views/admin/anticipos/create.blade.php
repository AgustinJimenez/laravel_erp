@extends('layouts.master')

@section('content-header')
    <h1>
        Crear Anticipo
    </h1>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.empleados.anticipos.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                        @include('empleados::admin.anticipos.partials.anticipo-fields')

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat" id="submit" >GUARDAR</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.empleados.anticipos.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    @include('empleados::admin.anticipos.partials.anticipo-script')
@stop
