    <?php                                    $debug = true;

if($debug)
    $debug = '';
else
    $debug = 'display:none;';
?>
@extends('layouts.master')

@section('content-header')
    <h1>
        @if($isVenta)
            Venta
        @elseif($isOtros)
            Otras Ventas
        @elseif($isPreventa)
            Preventa
        @endif
    </h1>
    
@stop

@section('styles')
    
    <style type="text/css">
        
        .width33
        {
            width: 32.5%!important;
            display: inline;
            margin-top:0%;
        }
        .text-center
        {
            text-align: center;
        }

        tbody 
        {
            /*
            height: 620px;
            overflow-y: auto;
            */
        }
        #cke_1_top
        {
            display: none;
        }

        #cke_1_bottom
        {
            display: none;
        }

        #cke_observacion_venta:hover
        {
            
        }
        /*
        table 
        {
            width: 100%;
            display:block;
        }
        thead 
        {
            display: inline-block;
            width: 100%;
            height: 20px;
        }
        tbody 
        {
            height: 600px;
            display: inline-block;
            width: 100%;
            overflow: auto;
            margin-top: 1%;
        }*/

        .invalido
        { 
            border: 2px solid red;
        }
        .valido
        { 
            border: 2px solid green;
        }
        .input_white
        {
            border:0px; 
            font-size:14pt; 
            background-color:white;
        }

        .ui-autocomplete 
        {
            position: absolute;
            z-index: 2150000000 !important;
            cursor: default;
            border: 2px solid #ccc;
            padding: 5px 0;
            border-radius: 2px;
        }
    </style>

@stop

@section('content')

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    @include('partials.form-tab-headers')
                    <div class="tab-content">
                        <?php $i = 0; ?>
                        @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                            <?php $i++; ?>
                            <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                
                                <div class="box-body cabecera">
                                    <div>
                                        @include('clientes::admin.clientes.partials.modal_create_cliente')
                                    </div>

                                    {!! Form::open(['route' => ['admin.ventas.venta.store'], 'method' => 'post', 'id' => 'formulario','role'=>'form']) !!}

                                        <div style="position: absolute; margin-left: 90%; display: none"> 
                                            <?php if($isVenta+1==1)$isVenta=0;?>
                                            <label style="{{$debug}}"></label>
                                            <input type='text' value=<?php echo"".$isVenta."" ?> name="isVenta" class="form-control" placeholder="isVenta" id="isVenta" style=" width: 40px; height: 15px;{{$debug}}"/>
                                            <div style="{{$debug}}">
                                                <input type="" class="input-sm" value="{{ old('cliente_id') }}" name="cliente_id" placeholder="cliente_id" id="cliente_id" placeholder="cliente id" readonly="" style=" width: 40px; height: 20px;">
                                            </div>
                                        </div>


                                        @include('ventas::admin.ventas.partials.cabecera')



<!--*************************************************Factura Modal *****************************************************************************************-->
    @if($isVenta)
        <div class="modal fade" id="facturaModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3c8dbc; color: #ffffff">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><h4 class="modal-title"><strong>Crear Venta</strong></h4></center>
                    </div>
                    <br>
                    <div class="modal-body">
                    <div class="row" style="">
                        <div class="col-sm-1">
                        </div>

                        <div class="col-sm-3">
                            {!! Form::normalInput('nro_factura', 'Nro Factura', $errors, (object)['nro_factura' => $nro_factura ], ['class' => 'form-control']) !!}
                        </div>
                        
                        <div class="col-sm-4 text-center">
                            <div class="form-group "><label for="nro_seguimiento">Nro de Sobre:</label>
                            <input class="input_white text-center" type="text" value="{{ $nro_seguimiento }}" id="nro_boleta" readonly=""></div>
                        </div>    
                    </div>

                        {!! Form::normalInput('total_a_pagar_factura', 'Total a Pagar:', $errors ,null, ['id'=>'total_pagar', 'readonly'=>''] ) !!} 
               
                        {!! Form::normalInput('total_pagado', 'Pago del Cliente:', $errors ,(object)['total_pagado' => ''], ['required'=>'','autofocus'] ) !!} 
                        
                        {!! Form::normalInput('vuelto_cliente', 'Vuelto:', $errors ,null, ['id'=>'vuelto','readonly'=>''] ) !!} 
                        
                         {!! Form:: normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado', 'credito'=>'Credito']) !!}

                        {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito']) !!}

                       

                       
                        {!! Form::hidden('generar_factura', '0') !!}
                        <div class="modal-body">
                        <div class="box-footer">
                            <div class="modal-footer">
                                <div style="display: none;">
                                    <button type="submit" class="btn btn-primary btn-flat submit_button" id="submit_button">Guardar</button>
                                </div>
                                <button type="button" class="btn btn-primary btn-flat" id="generar_factura" disabled="">Guardar y Generar Factura</button>
                                <button type="button" class="btn btn-danger pull-right btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                <!-- Modal content-->

                </div>

            </div>
        </div>
    @endif
<!--*************************************************Factura Modal*****************************************************************************************-->


<!--*************************************************Otras *****************************************************************************************-->
    @if($isOtros)
        <div class="modal fade" id="facturaModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3c8dbc; color: #ffffff">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><h4 class="modal-title"><strong>Crear Otras Ventas</strong></h4></center>
                    </div>
                    <div class="modal-body">
                    <div class="row" style="">
                        <div class="col-sm-1">
                        </div>

                        <div class="col-sm-3">
                            {!! Form::normalInput('nro_factura', 'Nro Factura', $errors, (object)['nro_factura' => $nro_factura ], ['class' => '']) !!}
                        </div>
                        
                    </div>

                        {!! Form::normalInput('total_a_pagar_factura', 'Total a Pagar:', $errors ,null, ['id'=>'total_pagar', 'readonly'=>''] ) !!} 
                        
                        {!! Form::normalInput('total_pagado', 'Pago del Cliente:', $errors ,(object)['total_pagado' => ''], ['required'=>'','autofocus'] ) !!} 
                        
                        {!! Form::normalInput('vuelto_cliente', 'Vuelto:', $errors ,null, ['id'=>'vuelto','readonly'=>''] ) !!} 
                        
                         {!! Form:: normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado', 'credito'=>'Credito']) !!}

                        {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $debe_contado->codigo_nombre ], ['required' => ''] ) !!}
                            <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $debe_contado->id }}">
                        </div>
                        <div class="col-md-6">
                            {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => $haber->codigo_nombre ], ['required' => ''] ) !!}
                            <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber->id }}">
                        </div>
                    </div>
                        {!! Form::hidden('is_otras_ventas', 1) !!}  
                        {!! Form::hidden('debe_contado_id', $debe_contado->id ) !!} 
                        {!! Form::hidden('debe_contado_nombre', $debe_contado->codigo_nombre ) !!}
                                              
                        {!! Form::hidden('generar_factura', '0') !!} 
                        {!! Form::hidden('debe_credito_id', $debe_credito->id ) !!} 
                        {!! Form::hidden('debe_credito_nombre', $debe_credito->codigo_nombre ) !!}
                        </div>
                        <div class="box-footer">
                            <div class="modal-footer">
                                <div style="display: none;">
                                    <button type="submit" class="btn btn-primary btn-flat submit_button" id="submit_button">Guardar</button>
                                </div>
                                <button type="button" class="btn btn-primary btn-flat" id="generar_factura" disabled="">Guardar y Generar Factura</button>
                                <button type="button" class="btn btn-danger pull-right btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                            </div>
                        </div>
                    </div>
                <!-- Modal content-->

                </div>

            </div>
        </div>
    @endif
<!--*************************************************Factura Modal*****************************************************************************************-->


<!--*************************************************Preventa Modal*****************************************************************************************-->
@if($isPreventa)
    <div class="modal fade" id="preventaModal" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background-color: #3c8dbc; color: #ffffff">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <center><h4 class="modal-title"><strong> Crear Preventa</strong></h4></center>
            </div>
            <div class="modal-body">
            <div class="row" style="">
                <div class="col-sm-1">
                </div>
                
                <div class="col-sm-4 text-center">
                    <div class="form-group "><label for="nro_seguimiento">Nro de Sobre:</label>
                    <input class="input_white text-center" type="text" value="{{ $nro_seguimiento }}" id="nro_boleta"></div>
                </div> 
            </div>

            <div class="modal-body">
                
                {!! Form::normalInput('total_a_pagar_factura', 'Total a Pagar:', $errors ,null, ['id'=>'total_pagar', 'readonly'=>''] ) !!} 

                {!! Form::normalInput('entrega_preventa', 'Entrega', $errors,null, ['autofocus']) !!}

                {{-- {!! Form::normalInput('vuelto_cliente', 'Vuelto:', $errors ,null, ['id'=>'vuelto','readonly'=>''] ) !!}  --}}

                {!! Form::normalInput('restante_preventa', 'Restante a Pagar:', $errors ,null, ['id'=>'restante_preventa','readonly'=>''] ) !!}

                {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito']) !!}
<!--
                {!! Form:: normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado', 'credito'=>'Credito']) !!}
-->
                {!! Form::hidden('generar_factura', '0') !!}

                {!! Form::hidden('isPreVenta', '1') !!}
                </div>
                <div class="box-footer">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-flat submit_button" id="submit_button">Guardar</button>
                        <button type="button" class="btn btn-danger pull-right btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                    </div>
                </div>
            </div>
          </div>
        <!-- Modal content-->
        </div>
    </div>
@endif
<!--*************************************************Preventa Modal*****************************************************************************************-->

                                    </div>
                                    
                                </div>
                            @endforeach

                            <div class="box-footer">
                                <div class="form-group">
                                    @if($isVenta)
                                        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#facturaModal">
                                            Crear Venta 
                                        </button>
                                    @endif
                                    @if($isOtros)
                                        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#facturaModal">
                                            Crear Venta 
                                        </button>
                                    @endif
                                    @if($isPreventa)
                                        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#preventaModal">
                                            Crear Preventa 
                                        </button>
                                    @endif
                                    
                                </div>
                            <!--
                                <button type="submit" class="btn btn-primary btn-flat submit-venta">Crear Venta</button>
                             -->
                                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.ventas.venta.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                            </div>
                        </div>
                    </div> {{-- end nav-tabs-custom --}}
                </div>
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
   
