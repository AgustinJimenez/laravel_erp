@extends('layouts.master')

@section('content-header')
    <h1>
        Alta/Baja de: <label for="">{{ $producto->nombre }}</label>   
           
    </h1>
        <li><strong>Categoria:</strong> {{ $producto->categoria->nombre }}</li>
        <li><strong>Codigo: </strong> {{ $producto->codigo }}</li>
        @if($permisos->get("Ver Precios de Compra"))
        <li><strong>Precio Compra:</strong>  {{ $producto->precio_compra }}</li>
        @endif
        <li><strong>Precio Venta: </strong> {{ $producto->precio_venta }}</li>
        <li><strong>Stock:</strong>  {{ $producto->stock }}</li>
        <li><strong>Stock Minimo: </strong> {{ $producto->stock_minimo }}</li> 



        
    <ol class="breadcrumb">
       
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.productos.altabajaproducto.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('productos::admin.altabajaproductos.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button  class="btn btn-primary btn-flat" id="fakesubmit" >Guardar</button>
                        <button type="submit" class="btn btn-primary btn-flat" style="display: none;">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.productos.altabajaproducto.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            
            


            $(document).keypressAction(
            {
                actions: [
                    { key: 'b', route: "<?= route('admin.productos.altabajaproducto.index') ?>" }
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
