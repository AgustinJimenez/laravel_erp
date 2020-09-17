@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('contabilidad::asientos.title.create asiento') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.contabilidad.asiento.index') }}">{{ trans('contabilidad::asientos.title.asientos') }}</a></li>
        <li class="active">{{ trans('contabilidad::asientos.title.create asiento') }}</li>
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
        .text-center
        {
            text-align: center;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.contabilidad.asiento.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('contabilidad::admin.asientos.partials.create-fields', ['lang' => $locale])



                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        {!! Form::normalInput('fecha', 'Fecha', $errors) !!}
                                    </div>

                                    <div class="form-group col-md-2">
                                        {!! Form::normalInput('operacion', 'Operacion', $errors) !!}
                                    </div>
                                </div>
                                
                                {!! Form::normalInput('observacion', 'Comentario', $errors) !!}
                                <div class="form-group" style="margin-left:1%;" >
                                    <a href="#" id="agregar" class="btn btn-primary btn-flat">Agregar</a>
                                </div>
                                <div class="overflow-x:auto;" id="div_tabla">
                                    <table id="tabla_detalle_venta" class="table table-bordered table-striped table-highlight table-fixed tabla_detalle_venta">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2 text-center" >Cuenta</th>
                                                <th class="col-sm-3 text-center">Observacion</th>
                                                <th class="col-sm-1 text-center">Debe</th>
                                                <th class="col-sm-1 text-center">Haber</th>
                                                <th class="col-sm-1 text-center">Accion</th>
                                            </tr>
                                        </thead>

                                        <tbody><?php 
                                    $row ='<td class="col-sm-2 input-group">
                                                <div id="divCuenta" class="form-group divCuenta" >

                                                    <input type="text" class="form-control input-sm cuenta_nombre" name="cuenta_nombre[]" id="cuenta_nombre" value="" placeholder="Nombre Cuenta" required="">

                                                    <input type="text" class="form-control input-sm  cuenta_id" name="cuenta_id[]" id="cuenta_id" value="" placeholder="id" readonly style="height:20px;width:40px;display:none;">
                                                </div>
                                            </td>

                                            <td class="col-sm-3 input-group">
                                                <div id="divObservacion" class="form-group divObservacion" >
                                                    <input type="text" class="form-control input-sm observacion" name="observacion_detalle[]" id="observacion" value="" placeholder="Observacion">
                                                </div>
                                            </td>
                                            <td class="col-sm-1 input-group">
                                                <div id="divDebe" class="form-group divDebe" >
                                                    <input type="text" class="form-control input-sm debe" name="debe[]" id="debe" value="" placeholder="Debe" required="">
                                                </div>
                                            </td>

                                            <td class="col-sm-1 input-group">
                                                <div id="divHaber" class="form-group divHaber" >
                                                    <input type="text" class="form-control input-sm haber" name="haber[]" id="haber" value="" placeholder="Haber" required="">
                                                </div>
                                            </td>';
                            $column_action = '<td class="col-sm-1" >
                                                <p  class="btn btn-danger remove_field">Eliminar</p>
                                            </td>';

                                            ;?>
                                            @if(!count($errors)>0)
                                                {!! $row !!}
                                            @else
                                                
                                                <td class="col-sm-2 input-group">
                                                    <div id="divCuenta" class="form-group divCuenta" >

                                                        <input type="text" class="form-control input-sm cuenta_nombre" name="cuenta_nombre[]" id="cuenta_nombre" value="" placeholder="Nombre Cuenta" required="">

                                                        <input type="text" class="form-control input-sm  cuenta_id" name="cuenta_id[]" id="cuenta_id" value="" placeholder="id" readonly style="height:20px;width:40px;display:noe;">
                                                    </div>
                                                </td>

                                                <td class="col-sm-3 input-group">
                                                    <div id="divObservacion" class="form-group divObservacion" >
                                                        <input type="text" class="form-control input-sm observacion" name="observacion[]" id="observacion" value="" placeholder="Observacion" required="">
                                                    </div>
                                                </td>
                                                <td class="col-sm-1 input-group">
                                                    <div id="divDebe" class="form-group divDebe" >
                                                        <input type="text" class="form-control input-sm debe" name="debe[]" id="debe" value="" placeholder="Debe" required="">
                                                    </div>
                                                </td>

                                                <td class="col-sm-1 input-group">
                                                    <div id="divHaber" class="form-group divHaber" >
                                                        <input type="text" class="form-control input-sm haber" name="haber[]" id="haber" value="" placeholder="Haber" required="">
                                                    </div>
                                                </td>;
                                                <td class="col-sm-1" >
                                                    <p  class="btn btn-danger remove_field">Eliminar</p>
                                                </td>
                                                
                                            @endif

                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>
                                                    
                                                    <td>
                                                        <strong style="float: right;">Monto total</strong>
                                                    </td>
                                                    <td >

                                                        <input type="text" name="total_debe" value="{{ old('total_debe') }}"  autocomplete=off class="form-control input-md total_debe" id="total_debe" readonly/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="total_haber" value="{{ old('total_haber') }}"  autocomplete=off class="form-control input-md total_haber" id="total_haber" readonly/>
                                                    </td>
                                                </th>
                                                
                                            </tr>
                                        </tfoot>

                                    </table>
                                    

                                </div>
                            </div>
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                        </div>
                    @endforeach

                    <div class="box-footer"> 
                        <p style="color: red; display: none;" class="message" id="message">La suma de Debe y Haber deben de ser iguales y distintos a 0</p>
                        <button type="submit" class="btn btn-primary btn-flat submit submit_button" id="submit" disabled="">Crear Asiento</button>

                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.contabilidad.asiento.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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

@include('contabilidad::admin.asientos.asiento-script')
