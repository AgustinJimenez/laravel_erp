<style type="text/css">

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

<div class="row">
    

    <div class="col-md-2">
        {!! Form::normalInput('fecha', 'Fecha', $errors, isset($compra)?$compra:(object)['fecha' => $fecha_hoy],['required' => '']) !!}
    </div>

    <div class=" col-md-4">
        {!! Form::normalInput('razon_social', 'Razon Social:', $errors, isset($compra)?$compra:null,['required' => '']) !!}
    </div>

    <div class="col-md-2">
        {!! Form::normalInput('ruc_proveedor', 'RUC:', $errors, isset($compra)?$compra:null,['required' => '']) !!}
    </div>

    <div style="{{ $debug }};width: 60px; height: 15px; position: absolute; margin-left:93%;">
        {!! Form::normalInput('proveedor_id', 'proveedor_id', $errors,isset($compra)?$compra:null) !!}
    </div>

    <div class="input-group" style="width: 3%; {{ $debug }};position:absolute; margin-left: 90%;">
        <input type="text" class="form-control input-sm" name="isProducto" value="{{ $isProducto }}" readonly="">
        <input type="text" class="form-control input-sm" name="isCristal" value="{{ $isCristal }}" readonly="">
        <input type="text" class="form-control input-sm" name="isServicio" value="{{ $isServicio }}" readonly="">
        <input type="text" class="form-control input-sm" name="isOtro" value="{{ $isOtro }}" readonly="">
    </div>

</div>

<div class="row">

    <div class="col-md-3">


    </div>

    <div class="col-md-3">
        {!! Form::normalSelect('moneda', 'Moneda:', $errors, ['Guaranies'=>'Guarani','Dolares'=>'Dolar','Euros'=>'Euro'], isset($compra)?$compra:(object)['cambio' => 'Guaranies']) !!} 
    </div>

    <div class="col-md-2">
        {!! Form::normalInput('cambio', 'Cambio:', $errors, isset($compra)?$compra:(object)['cambio' => 1], ['required' => ''] ) !!}
    </div>
    

</div>
{{--*********************************************DETAILS******************************************************************************--}}
@if( isset($detalles) )
    @include('compras::admin.compras.partials.detalles_edit')
@else
    @include('compras::admin.compras.partials.detalles_create')
@endif    
{{--*********************************************DETAILS******************************************************************************--}}                      
<div class="form-group" style="margin-left:1%;" >
    <a href="#" id="agregar" class="btn btn-primary btn-flat">Agregar Detalle</a>
</div>
{!! Form::normalInput('monto_total', 'Monto Total (Guaranies)', $errors,isset($compra)?$compra:null, ['readonly' => '']) !!}
{!! Form::normalInput('monto_total_letras', 'Total a Pagar', $errors,isset($compra)?$compra:null, ['readonly' => '']) !!}
<div class="row">

    <div class="col-md-4">
        {!! Form::normalInput('total_iva_5', 'IVA 5%', $errors,isset($compra)?$compra:null, ['readonly' => '']) !!}
    </div>

    <div class="col-md-4">
        {!! Form::normalInput('total_iva_10', 'IVA 10%', $errors,isset($compra)?$compra:null, ['readonly' => '']) !!}
    </div>

    <div class="col-md-4">
        {!! Form::normalInput('total_iva', 'IVA Total', $errors,isset($compra)?$compra:null, ['readonly' => '']) !!}
    </div>

</div> 



{!! Form::normalInput('observacion', 'Observacion', $errors, isset($compra)?$compra:null) !!}
{!! Form::normalCheckbox('pagado_por', 'Pagado Por', $errors, isset($compra)?$compra:null) !!}
{!! Form::normalCheckbox('comprobante', 'Comprobante Valido', $errors,isset($compra)?$compra:(object)['comprobante' => 1]) !!}

{!! Form::normalInput('comentario_pagado_por', 'Comentario', $errors, isset($compra)?$compra->comentario_pagado_por:null) !!}


<div class="box-footer">
    @if(isset($detalles) )
        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#pagoModal">Actualizar Compra</button>
    @else   
        <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#pagoModal">Crear Compra</button>
    @endif
    
    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.compras.compra.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
</div>

<!--*************************************************Modal_Pago*****************************************************************************************-->
    <div class="modal fade" id="pagoModal" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background-color:#3c8dbc; color: #ffffff " >
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              @if(isset($detalles))
                <center><h4 class="modal-title"><strong>Actualizar Compra</strong></h4></center>
              @else
                <center><h4  class="modal-title"><strong>Crear Compra</strong></h4></center>
              @endif
              
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-3">
                    {!! Form::normalInput('nro_factura', 'Nro de Factura:', $errors, isset($compra)?$compra:null) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::normalInput('timbrado', 'Timbrado:', $errors, isset($compra)?$compra:null) !!}
                </div>
            </div>

                {!! Form::normalInput('total_pagar', 'Total a Pagar:', $errors, null, ['readonly' => '']) !!}

                {!! Form::normalInput('total_pagado', 'Total Pagado', $errors, isset($compra)?$compra:'0', ["autofocus"]) !!}

                {!! Form::normalInput('vuelto_cliente', 'Vuelto:', $errors, null, ['readonly' => '']) !!}


                {!! Form::normalSelect('tipo_factura', 'Tipo de Factura:', $errors, ['contado'=>'Contado','credito'=>'Credito'], isset($compra)?$compra:null) !!} 
    
                {!! Form::normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito'=>'Tarjeta de Credito', 'tarjeta_debito'=>'Tarjeta de Debito'], isset($compra)?$compra:null) !!} 

                            <div class="row">

                @if($isProducto == true)  
                    
                    <div class="col-md-6">
                        {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $debe->codigo.' -'.$debe->nombre ], ['required' => ''] ) !!}
                        <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $debe->id }}">
                    </div>

                    <div class="col-md-6">
                        {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => ($haber_contado->codigo.' -'.$haber_contado->nombre) ], ['required' => ''] ) !!}
                        <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber_contado->id }}">
                    </div>


                @elseif($isCristal == true)
                    <div class="col-md-6">
                        {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $debe->codigo.' -'.$debe->nombre ], ['required' => ''] ) !!}
                        <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $debe->id }}">
                    </div>

                    <div class="col-md-6">
                        {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => ($haber_contado->codigo.' -'.$haber_contado->nombre) ], ['required' => ''] ) !!}
                        <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber_contado->id }}">                        
                    </div>
                    


                @elseif($isServicio == true)
                    
                    <div class="col-md-6">
                        {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $debe->codigo.' -'.$debe->nombre ], ['required' => ''] ) !!}
                        <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $debe->id }}">
                    </div>

                    <div class="col-md-6">
                        {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => ($haber_contado->codigo.' -'.$haber_contado->nombre) ], ['required' => ''] ) !!}
                        <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber_contado->id }}">
                    </div>


                @elseif($isOtro == true)
                    
                    <div class="col-md-6">
                        {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $debe->codigo.' -'.$debe->nombre ], ['required' => ''] ) !!}
                        <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $debe->id }}">
                    </div>

                    <div class="col-md-6">
                        {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => ($haber_contado->codigo.' -'.$haber_contado->nombre) ], ['required' => ''] ) !!}
                        <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber_contado->id }}">
                    </div>

                @endif
                
                
            </div>
                <div class="box-footer">
                    
                    <div class="modal-footer">
                        @if(isset($detalles) )
                            <button type="submit" class="btn btn-primary btn-flat" id="submit">Actualizar Compra</button>
                        @else
                            <button type="submit" class="btn btn-primary btn-flat" name="crear_compra" id="submit">Crear Compra</button>
                        @endif
                        
                        <button type="button" class="btn btn-danger pull-right btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                    </div>
                </div>
            </div>
          </div>
        <!-- Modal content-->
        </div>
    </div>
{!! Form::close() !!}

{!! Form::hidden('haber_contado_id', isset($haber_contado)?$haber_contado->id:null ) !!}
{!! Form::hidden('haber_contado_nombre', isset($haber_contado)?($haber_contado->codigo.' -'.$haber_contado->nombre):null ) !!}

{!! Form::hidden('haber_credito_id', isset($haber_credito)?$haber_credito->id:null ) !!}
{!! Form::hidden('haber_credito_nombre', isset($haber_credito)?$haber_contado->codigo.' -'.$haber_credito->nombre:null) !!}
<!--*************************************************Modal_Pago*****************************************************************************************-->