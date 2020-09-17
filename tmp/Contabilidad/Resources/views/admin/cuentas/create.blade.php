@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('contabilidad::cuentas.title.create cuenta') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.contabilidad.cuenta.index') }}">{{ trans('contabilidad::cuentas.title.cuentas') }}</a></li>
        <li class="active">{{ trans('contabilidad::cuentas.title.create cuenta') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.contabilidad.cuenta.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('contabilidad::admin.cuentas.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.contabilidad.cuenta.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    {!! Theme::script('vendor/jquery-ui/jquery-ui.min.js') !!}
    {!! Theme::style('css/jquery-ui.min.css') !!}
    <script type="text/javascript">
        $( document ).ready(function() 
        {

    

   
        $("#activo").prop('checked',true);

        $( "#nombre_padre" ).autocomplete(
        {
            source: '{!! route('admin.contabilidad.cuenta.search_padre') !!}',

            minLength: 1,

            select: function(event, ui) 
            {
                $( "#padre" ).val( ui.item.id );
            }

        });
    








            $(document).keypressAction(
            {
                actions: [
                    { key: 'b', route: "<?= route('admin.contabilidad.cuenta.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@stop
