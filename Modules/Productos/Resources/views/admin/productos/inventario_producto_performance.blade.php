@extends('layouts.master')
@section('content-header')
<h1>
Personalizar Reporte de Inventario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('admin.ventas.facturaventa.index') }}">{{ trans('Personalizar Reporte') }}</a></li>
    <li class="active">{{ trans('Personalizar Reporte') }}</li>
</ol>
@stop
@section('styles')
{!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop
@section('content')
{!! Form::open(['route' => ['admin.productos.producto.inventario_producto_pdf'], 'method' => 'post', 'id' => 'inventario-form']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            @include('partials.form-tab-headers')
            <div class="tab-content">
                <?php $i = 0; ?>
                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                <?php $i++; ?>
                <!--***************************************************************************************-->
                <div class="box-body">
                <h4><u>Opciones de Reporte :</u></h4>

                <div class="row">
                    <div class="col-md-3">
                        {!! Form::normalCheckbox('imagen', 'Ver Imágenes', $errors) !!}
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        {!! Form::normalCheckbox('precio_compra', 'Ver Precios de Compra', $errors) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        {!! Form::normalCheckbox('precio_venta', 'Ver Precios de Venta', $errors) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::button('EXPORTAR A EXCEL', array('class' => 'btn btn-success exportar-button-excel')) !!}
                        {!! Form::hidden('exportar-excel', 0) !!}
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-6">
                    <h4><u>Seleccion Categoria/s :</u></h4>

                        <p><label><input type="checkbox" id="checkAll" class="iCheck-helper" checked> Seleccionar Todos</label></p>
                        <div style="width: 100%; height: 370px; overflow-y: scroll;">
                        @foreach($categorias as $value => $name)
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::checkbox('categoria[]', $value, false, ['id' => 'categoria' . $value, 'class' => 'checkbox-categorias', 'checked' => 'checked']) !!} {!! Form::label('categoria' . $value, $name) !!}
                            </div>
                        </div>
                        
                        @endforeach
                        </div>
                    </div>    
                </div>
                
                @endforeach
                <br>
                </div>
                <div class="box-footer">
                    <!--
                    <button type="submit" class="btn btn-primary btn-flat" formtarget="_blank" id="button-generar-reporte">Generar Reporte</button>
                    -->
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
@section('scripts')

<script>
    $( document ).ready(function()
    {
    $("#checkAll").change(function ()
    {
        $("input:checkbox.checkbox-categorias").prop('checked', $(this).prop("checked"));
    });

    $(".exportar-button-excel").click(function()
    {
        $("input[name=exportar-excel]").val(1);
        $("#inventario-form").submit();
    });

    $("#button-generar-reporte").click(function()
    {
        $("input[name=exportar-excel]").val(0);
    });

    

    $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.productos.producto.inventario_producto_performance') }}" }]});

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });
    });
</script>
@stop