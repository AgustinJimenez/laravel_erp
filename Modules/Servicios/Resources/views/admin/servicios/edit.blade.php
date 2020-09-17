@extends('layouts.master')

@section('content-header')
    <h1>
        Editar Servicio
    </h1>
    <ol class="breadcrumb">
        
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}

    <style type="text/css">
        
        #cke_1_top
        {
            display: none;
        }

        #cke_1_bottom
        {
            display: none;
        }
        
    </style>
    
@stop

@section('content')
    {!! Form::open(['route' => ['admin.servicios.servicio.update', $servicio->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('servicios::admin.servicios.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button  class="btn btn-primary btn-flat" id="fakesubmit">Guardar</button>
                        <button type="submit" class="btn btn-primary btn-flat" style="display: none;">{{ trans('core::core.button.update') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.servicios.servicio.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
        $( document ).ready(function() 
        {
            $(window).keydown(function(event)
            {
                if(event.keyCode == 13) {
                  event.preventDefault();
                  $("#fakesubmit").click();
                  return false;
                }
            });

            $("#precio_venta").number( true , 0, '', '.' );

            $("#fakesubmit").click(function()
            {

                $("#precio_venta").number( true , 0, '', '' );

                $("#submit").click();

            });





            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.servicios.servicio.index') ?>" }
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
