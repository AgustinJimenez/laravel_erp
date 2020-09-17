    <?php                                         $debug = true;

if($debug)
    $debug = '';
else
    $debug = 'display:none;';
    
?>
@extends('layouts.master')

@section('content-header')
    <h1>
        @if(!$venta->anulado)
            @if($venta->tipo=='preventa')
                Completar Venta
            @else
                Detalles de venta
            @endif
        @else
            @if($venta->tipo=='preventa')
                Preventa Anulada
            @else
                Venta Anulada
            @endif
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
            height: 620px;
            overflow-y: auto;
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
        .invalido
        { 
            border: 2px solid red;
        }
        .valido
        { 
            border: 2px solid green;
        }
        .inline
        {
            display: inline;
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
                                @if(!$venta->anulado) 
                                    <div class="row"> 
                                        <div class="col-md-6"> 
                                        </div> 
{{--                                         <div class="col-md-4"> 
                                            {!! Form::open(['route' => ['admin.ventas.venta.anular_factura', $venta->id], 'method' => 'post']) !!} 
                                                {!! Form:: normalCheckbox('anulado', 'Anular Factura', $errors, $venta) !!}  
                                                {!! Form::submit('Actualizar', array('class' => 'btn btn-primary btn-flat')) !!} 
                                            {!! Form::close() !!} 
                                        </div>  --}}
                                    </div>  
                                @endif 
                                <div class="col-md-3 text-center">
                                    @include('clientes::admin.clientes.partials.modal_cliente') 
                                </div>
                                {!! Form::open(['route' => ['admin.ventas.venta.update', $venta->id], 'method' => 'put', 'id' => 'formulario', 'role'=>'form']) !!} 
                                         
                                        <div style="{{$debug}};position: absolute; margin-left: 90%;display: none;"> 
                                            <input type="" value="{{ old('cliente_id',$venta->cliente_id) }}" name="cliente_id" placeholder="cliente_id" id="cliente_id" placeholder="cliente id" readonly="" style=" width: 50px; height: 15px;"> 
                                        </div> 
 
                                        @include('ventas::admin.ventas.partials.cabecera') 
                                        @if($venta->tipo =='preventa' and $venta->anulado and count($venta->asientos_all))
                                            <div class="row">

                                                <hr>
                                                <div class="col-md-1"></div>
                                                <h2>Asientos</h2>
                                                <br>
                                                <div class="col-md-1"></div>
                                                @foreach ($venta->asientos_all as $asiento)
                                                    {!! $asiento->edit_button !!}
                                                @endforeach
                                            </div>
                                        @endif
 
                                    </div> 
                                    
                                </div> 
                            @endforeach

                            <div class="box-footer">
                                <div class="form-group">
                                @if(!$venta->anulado)
                                    @if( $venta->tipo=='venta' )
                                        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#facturaModal">Actualizar Venta 
                                        </button>
                                    @else
                                        @include('ventas::admin.ventas.partials.preventa-anular-confirmation-modal')
                                        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#preventaModal">Completar Venta</button>
                                        <button class="btn btn-danger" id="anular-preventa-button" type="button" data-toggle="modal" data-target="#preventa-anular-confirmation" >Anular Preventa</button>
                                       
                                        <div class="modal fade modal-danger" id="preventa-anular-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
                                            <div class="modal-dialog">

                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                                        <h4 class="modal-title text-center" id="delete-confirmation-title">CONFIRMACI&Oacute;N</h4>
                                                    </div>

                                                    <div class="modal-body text-center">
                                                        <div id="mensaje-eliminar">DESEA ANULAR LA PREVENTA? SE GENERARA UN CONTRA-ASIENTO.</div>
                                                    </div>

                                                    
                                                    <div class="modal-footer">
                                                    <a class="btn btn-outline btn-flat" href="{{ route('admin.ventas.venta.anular_asientos_preventa', $venta->id) }}"> <b> ANULAR </b> </a>
                                                    <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">CANCELAR</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        
                                    @endif
                                @endif
                            </div>

                            <!--
                                <button type="submit" class="btn btn-primary btn-flat submit-venta">Crear Venta</button>
                             --></button>
                                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.ventas.venta.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                                
                            </div>
                        </div>
                    </div> {{-- end nav-tabs-custom --}}
                </div>
            </div>
        </div>


<!--*************************************************Factura-Modal*****************************************************************************************-->
    @if($venta->tipo=='venta') 
        <div class="modal fade" id="facturaModal" role="dialog">
            <div class="modal-dialog">


                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><strong>Actualizar Venta</strong></h4>
                    </div>

                    <div class="modal-body">

                        <div class="row" style="">
                            <div class="col-sm-1">
                            </div>

                            <div class="col-sm-3">
                                
                                {!! Form::label('nro_factura', 'Nro Factura') !!}
                                {!! Form::text('nro_factura', isset($venta->factura)?$venta->factura->nro_factura:'sin factura', array('class' => 'input_white', 'tabIndex' => "-1")) !!}
                            </div>
                            
                            <div class="col-sm-4 text-center">
                                {!! Form::label('nro_seguimiento', 'Nro de Seguimiento:') !!}
                                {!! Form::text('nro_seguimiento', $venta->nro_seguimiento, array('id'=>'nro_seguimiento', 'readonly'=>'', 'class' => 'input_white text-center', 'tabIndex' => "-1")) !!}
                            </div>    
                        </div>
                        
                            <div class="form-group">
                                
                                {!! Form::label('total_a_pagar_factura', 'Total a Pagar:') !!}
                                {!! Form::text('total_a_pagar_factura', old('total_a_pagar_factura') , array('class' => 'form-control total_pagar', 'tabIndex' => "-1", 'id' => 'total_pagar', 'readonly' => '')) !!}
                            </div>
                        
                        <div class="form-group has-feedback">
                            <label for="total_pagado">Pago del Cliente:</label>
                            <input type="text" name="total_pagado" value="{{ old('total_pagado',$venta->total_pagado) }}" class="form-control total_pagado" id="total_pagado" required>
                        </div>

                        <div class="form-group">
                            <label for="vuelto">Vuelto:</label>
                            <input type="text" name="vuelto_cliente" value="{{ old('vuelto_cliente') }}"  class="form-control vuelto" id="vuelto" readonly="">
                        </div>
                        
                        {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito'], $venta) !!}

                        {!! Form:: normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado', 'credito'=>'Credito'], $venta) !!}

                        {!! Form::hidden('generar_factura', '0') !!}
                        
                        <div class="box-footer">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-flat submit-imprimir submit_button">Actualizar Venta</button>
                                
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
@if($venta->tipo=='preventa')
    <div class="modal fade" id="preventaModal" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><strong>Completar Venta</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row" style="">
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-3">
                        
                        {!! Form::label('nro_factura', 'Nro Factura') !!}
                        {!! Form::text('nro_factura', isset($nro_factura)?$nro_factura:'sin factura', array('class' => 'form-control', 'tabIndex' => "-1")) !!}

                    </div>
                    
                    <div class="col-sm-4 text-center">
                        {!! Form::label('nro_seguimiento', 'Nro de Sobre:') !!}
                        {!! Form::text('nro_seguimiento', $venta->nro_seguimiento, array('id'=>'nro_seguimiento', 'readonly'=>'', 'class' => 'input_white text-center nro_sobre2', 'tabIndex' => "-1")) !!}
                    </div>    
                </div><br>
                
                <div class="form-group">
                    
                    {!! Form::label('total_a_pagar_factura', 'Total a Pagar:') !!}
                    {!! Form::text('total_a_pagar_factura', old('total_a_pagar_factura') , array('class' => 'form-control total_pagar', 'tabIndex' => "-1", 'id' => 'total_pagar', 'readonly' => '')) !!}
                </div>

                {!! Form::normalInput('entrega', 'Entrega Inicial:', $errors, isset($venta)?$venta:'0 ', ['class' => 'form-control input_white','readonly' => '', 'tabIndex' => "-1"]) !!}
                {!! Form::hidden('entrega', $venta->entrega) !!}

                <div class="row">

                    <div class="col-md-4">

                        <strong><p>Total de Pagado:</p></strong> 
                        <strong><p>Restante a Pagar:</p></strong> 
                        {{-- <strong><p>&nbsp;&nbsp;&nbsp;</p></strong>  --}}
                    </div>

                    <div class="col-md-1">

                        <p id="suma_total_pagos">{{ $venta->entrega }}</p>
                                        
                        <p id="resta">{{ number_format( ($venta->monto_total-$venta->entrega), 0, '', '.') }}</p>
                        
                        {{-- <p id="restante">{{ ($venta->monto_total-$venta->entrega) }}</p> --}}
                    </div>

                </div>

                {!! Form::normalInput('vuelto_cliente', 'Vuelto:', $errors ,null, ['id'=>'vuelto'] ) !!} 

                {!! Form::normalInput('pago_final', 'Pago Final', $errors, $venta, ['required' => '','autofocus']) !!}

                {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito'], null) !!}

                {!! Form:: normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado', 'credito'=>'Credito'], $venta->factura) !!}
                
                {!! Form::hidden('isPreVenta', '1') !!}

                {!! Form::hidden('generar_factura', '1') !!}
                <div class="box-footer">
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-flat submit_button" id="guardar">Guardar y Generar Factura</button>
                        <button type="button" class="btn btn-danger pull-right btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>Cancelar</button>
                    </div>
                </div>
            </div>
          </div>
        <!-- Modal content-->
        </div>
    </div>
@endif

<!--*************************************************Preventa Modal*****************************************************************************************-->
    {!! Form::close() !!}

<!--*************************************************Cliente Modal *****************************************************************************************-->


<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--************************************************* Agregar Item Preventa Modal *****************************************************************************************-->
    @if( isset($venta) and $venta->tipo == "preventa" and !$venta->anulado)
        @include('ventas::admin.ventas.partials.agregar-items-preventa')
        @include('ventas::admin.ventas.partials.agregar-items-preventa-js.main')
    @endif
<!--************************************************* Agregar Item Preventa Modal *****************************************************************************************-->
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
   
