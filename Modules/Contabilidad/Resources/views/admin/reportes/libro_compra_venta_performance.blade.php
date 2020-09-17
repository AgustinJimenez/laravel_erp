@extends('layouts.master')

@section('content-header')
    <h1>
        @if(isset($compra))
            Libro Compra - Personalizar Fecha de Reporte
        @else
            Libro Venta - Personalizar Fecha de Reporte
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="#">{{ trans('Libros Contables ') }}</a></li>
        <li class="active">{{ trans('Libros Contables ') }}</li>
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
                    @if(isset($compra))
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************factura-fileds.blade.php**************************************************-->
                    
                    {!! Form::open(['route' => ['admin.contabilidad.reportes.libro_compra_pdf'], 'method' => 'post', 'id' => 'search-form']) !!}

                        <div class="box-header">
                            <div class="col-md-2">
                                <table>
                                <tr>
                                <td>{!! Form::normalInput('fecha_inicio','Fecha Inicio', $errors ) !!}</td>
                                <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
                                </tr>
                                </table>
                            </div >

                            <div class="col-md-2">
                                <table>
                                <tr>
                                <td>{!! Form::normalInput('fecha_fin','Fecha Fin', $errors ) !!}</td>
                                <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
                                </tr>
                                </table>
                            </div>
<!--**************************factura-fileds.blade.php**************************************************-->
                        </div>
                    @endforeach

                    <div class="box-footer ">
<!--
                    <button class="btn btn-primary btn-flat btn-danger" type="submit" value="" formtarget="_blank"> Ver Reporte PDF</button>
-->
                    {!! Form::button('Ver Reporte EXCEL', array('class' => 'btn btn-primary btn-flat btn-success', 'formtarget' => '_blank', 'id' => 'button_excel')) !!}
                        {{-- <a class="btn btn-primary btn-flat" href="{{ route('admin.contabilidad.reportes.ingreso_egreso')}}"> Ver Reportes </button> --}}
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('dashboard.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>

                    </div>
                     {!! Form::close() !!} 
                    @else
                      

                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
<!--**************************factura-fileds.blade.php**************************************************-->
                    
                    {!! Form::open(['route' => ['admin.contabilidad.reportes.libro_venta_pdf'], 'method' => 'post', 'id' => 'search-form']) !!}

                        <div class="box-header">
                            <div class="col-md-2">
                                <table>
                                <tr>
                                <td>{!! Form::normalInput('fecha_inicio','Fecha Inicio', $errors ) !!}</td>
                                <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
                                </tr>
                                </table>
                            </div >

                            <div class="col-md-2">
                                <table>
                                <tr>
                                <td>{!! Form::normalInput('fecha_fin','Fecha Fin', $errors ) !!}</td>
                                <td>{!! Form::button( '<i class="fa fa-trash"></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
                                </tr>
                                </table>
                            </div>
                        </div>
                      
<!--**************************factura-fileds.blade.php**************************************************-->
                        </div>
                    @endforeach


                     

                    <div class="box-footer ">
                    <!--
                    <button class="btn btn-primary btn-flat btn-danger" type="submit" value="" formtarget="_blank"> Ver Reporte PDF</button>
                    -->
                        {!! Form::button('Ver Reporte EXCEL', array('class' => 'btn btn-primary btn-flat btn-success', 'formtarget' => '_blank', 'id' => 'button_excel')) !!}
                        {{-- <a class="btn btn-primary btn-flat" href="{{ route('admin.contabilidad.reportes.ingreso_egreso')}}"> Ver Reportes </button> --}}
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('dashboard.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>

                    </div>
                     {!! Form::close() !!} 
                    @endif

                    @if(isset($venta))
                        {!! Form::open(['route' => ['admin.contabilidad.reportes.libro_venta_excel'], 'method' => 'post', 'id' => 'form_excel']) !!}
                    @else
                        {!! Form::open(['route' => ['admin.contabilidad.reportes.libro_compra_excel'], 'method' => 'post', 'id' => 'form_excel']) !!}
                    @endif

                            {!! Form::hidden('fecha_inicio_excel', '') !!}    {!! Form::hidden('fecha_fin_excel', '') !!}

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
    {!! Theme::style('css/bootstrap-datetimepicker.min.css') !!}
    {!! Theme::script('js/moment.js') !!}
    {!! Theme::script('js/moment.es.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.min.js') !!}
    {!! Theme::script('js/bootstrap-datetimepicker.es.js') !!}
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(document).ready(function()
        {
            var today = new Date();
            //console.log(today);
            var dia = today.getDate();
            var mes = today.getMonth()+1; //January is 0!
            var año = today.getFullYear();

            $("#button_excel").click(function()
            {
                console.log('clicked');

                var fecha_inicio = $("input[name=fecha_inicio]").val();

                var fecha_fin = $("input[name=fecha_fin]").val();

                $("input[name=fecha_inicio_excel").val( fecha_inicio );

                $("input[name=fecha_fin_excel").val( fecha_fin );

                $("#form_excel").submit();

            });

            $('#fecha_inicio').val(1+"/"+mes+"/"+año);

            $('#fecha_fin').val(dia+"/"+mes+"/"+año);

            $('#fecha_inicio').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $('#fecha_fin').datetimepicker(
            {
                format: 'DD/MM/YYYY',
                //format: 'YYYY-MM-DD',
                locale: 'es'
            });

            $('#borrar_fecha_inicio').click(function()
            {
                $('#fecha_inicio').val('');
                
            });

            $('#borrar_fecha_fin').click(function()
            {
                $('#fecha_fin').val('');
            });
    
        });
            
    </script>
@stop