    <?php                                   $debug = true;

if($debug)
    $debug = '';
else
    $debug = 'display:none;';
?>
<style type="text/css">
    label[for=monto_total]{display: none;}
    label[for=monto_sub_total]{display: none;}
    label[for="cantidad"]{display: none;}
    label[for="descripcion"]{display: none;}{display: none;}
    label[for="precio_unitario"]{display: none;}
    .input_white
    {
        border:0px; 
        font-size:14pt; 
        background-color:white;
    }
    hr {
        color: #3c8dbc;
    }

</style>
        <div class="row">
            @if($facturaventa->venta->nro_seguimiento)
            <div class="col-md-2"> 
                {!! Form::label('nro_boleta', 'Nro de Sobre:', array('class' => 'mylabel')) !!}
                {{ $facturaventa->venta->nro_seguimiento }}<br>
            </div>
            @endif
            <div class="col-md-2">
                {!! Form::label('fecha_venta', 'Fecha de Venta') !!}
                {!! Form::text('fecha_venta', isset($facturaventa->venta)?$facturaventa->venta->format('fecha_venta', 'date'):null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
            @if($facturaventa->venta and $facturaventa->venta->fecha_entrega != "0000-00-00" and $facturaventa->venta->fecha_entrega)
            <div class="col-md-2">
                {!! Form::label('fecha_entrega', 'Fecha de Entrega') !!}
                {!! Form::text('fecha_entrega', isset($facturaventa->venta)?$facturaventa->venta->format('fecha_entrega', 'date'):null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
            @endif
            <div class="col-md-3 text-center">
            @if($facturaventa->venta->usuario_create)
                {!! Form::label('usuario_create', 'Creado por:') !!}
                {{ $facturaventa->venta->usuario_apellido_nombre('create') }}
            @endif
            <br>
            @if($facturaventa->venta->usuario_edit)
                {!! Form::label('usuario_edit', 'Ult Editado por:') !!}
                {{ $facturaventa->venta->usuario_apellido_nombre('edit') }}
            @endif
            </div>
        </div>
        @if($facturaventa->venta->nro_seguimiento)
        <div class="row">
            <div class="col-md-2 text-center">    
                <a class="btn btn-primary btn-flat" href="{{ route('admin.ventas.venta.edit_nro_seguimiento', ['nro_seguimiento='.$facturaventa->venta->nro_seguimiento , 'venta_id='.$facturaventa->venta->id]) }}"> Editar N° de Sobre</a>
            </div>
        </div>
        @endif
    <br>
    <br>
<div class="box-body cabecera">
	<div class="row">
        <div class="form-group col-md-6">
	        <div> 
                {!! Form::label('razon_social', 'Razon Social') !!}
                {!! Form::text('razon_social', isset($facturaventa->venta)?$facturaventa->venta->cliente->razon_social:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}

            </div>
	    </div>
	    <div class="form-group col-md-6">
            <div> 
                {!! Form::label('direccion', 'Localidad') !!}
                {!! Form::text('direccion', isset($facturaventa->venta)?$facturaventa->venta->cliente->direccion:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-md-2">
            <div> 
                {!! Form::label('ruc', 'RUC') !!}
                {!! Form::text('ruc', isset($facturaventa->venta)?$facturaventa->venta->cliente->ruc:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
        </div>
        <div class="form-group col-md-2">
            <div> 
                {!! Form::label('celular', 'Celular') !!}
                {!! Form::text('celular', isset($facturaventa->venta)?$facturaventa->venta->cliente->celular:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
        </div>
        <div class="form-group col-md-2">
            <div>
                {!! Form::normalSelect('tipo_factura', 'Tipo de Factura', $errors, ['contado' => 'Contado','credito' => 'Credito'],  isset($facturaventa)?$facturaventa:null, ['disabled' => '', 'tabIndex' => "-1"]) !!}
            </div>
        </div>

        <div class="form-group col-md-2">
        	<div> 
                {!! Form::label('fecha', 'Fecha') !!}
                {!! Form::text('fecha', isset($facturaventa)?$facturaventa->fecha_formateada:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('nro_factura', 'Nro. de Factura') !!}
            {!! Form::text('nro_factura', isset($facturaventa)?$facturaventa->nro_factura:null, array('class' => 'form-control input_white', 'tabIndex' => "-1", 'readonly'=>'')) !!}
        </div>

    </div>
</div>

<div class="box-body detalle div_tabla"> 
    <table id="tabla_factura" class="table table-bordered table-striped table-highlight table-fixed"> 
        <thead> 
        <tr> 
            <th class="col-sm-1 text-center">Cantidad</th> 
            <th class="col-sm-4 text-center">Descripcion</th> 
            <th class="col-sm-1 text-center">IVA</th> 
            <th class="col-sm-1 text-center">P. Unt.</th> 
            <!--
            <th class="col-sm-2 text-center">Sub Total</th> 
            -->
            <th class="col-sm-2 text-center">Total</th> 
        </tr> 
 
        </thead> 
        <?php $c = 0;?> 
        <tbody id="factura_detalles">  

            @foreach($detalles as $key => $detalle) 
                <tr id="{{ 'fila'.$key }}" class="fila"> 

                    <td class="col-sm-1"> 
                        {!! Form::normalInput('cantidad', '&thinsp;', $errors, isset($detalle->cantidad)?(object)['cantidad' => $detalle->wformat('cantidad')]:'', ['style' => '', 'id'=> 'cantidad', 'required' => '', 'disabled' => '']) !!}    
                    </td> 

                    <td class="col-sm-4"> 
                        {!! Form::normalInput('descripcion', '&thinsp;', $errors, isset($detalle->descripcion_producto)?(object)['descripcion' => $detalle->descripcion_producto]:$detalle->descripcion, ['style' => '', 'id'=> 'descripcion', 'disabled' => '']) !!} 
                    </td> 

                    <td class="col-sm-2"> 
                     
                        {!!  
                            Form::select('iva[]',[ 
                                                    '0' => 'excenta', 
                                                    '21' => '5%', 
                                                    '11' => '10%' 

                                                 ], isset($detalle->iva)?$detalle->iva:'',  

                            ['class' => 'form-control iva', 'id' => 'iva', 'disabled' => '']) 
                        !!} 
                     
                    </td> 

                    <td class="col-sm-1"> 
                        {!! Form::text('precio_unitario[]',isset($detalle->precio_unitario)?$detalle->precio_unitario:'', array('class' => 'form-control input-md precio_unitario', 'id' => 'precio_unitario', 'required' => '', 'disabled' => '')) !!} 
                    </td> 

                    <td class="col-sm-2"> 
                        {!! Form::text('sub_total[]',null, array('class' => 'form-control input-md text-center sub_total', 'id' => 'sub_total', 'readonly' => '', 'tabIndex' => "-1")) !!} 
                    </td> 
                    <!--
                    <td class="col-sm-2"> 
                        {!! Form::text('total[]',null, array('class' => 'form-control input-md text-center total', 'id' => 'total', 'readonly' => '', 'tabIndex' => "-1")) !!} 
                    </td> 
                    -->

                </tr> 

            @endforeach 
        </tbody>
        <tfoot> 
        <tr>
            <td class="text-right" colspan="4">
                <strong>Total Descuentos</strong>
            </td>
            <td >
                <input type="text" name="descuento_total" value="{{number_format($venta->descuento_total,0," ",".")}}"  autocomplete=off class="form-control input-md descuento_total text-center" id="descuento_total"  readonly="">
            </td>
        </tr>
        <tr> 
            <th colspan="4" class="text-right">{!! Form::label('', 'Monto total', array('class' => 'control-label')) !!}</th> 
            <td colspan="1"> 
                <input type="text" name="monto_sub_total" value="{{ number_format($venta->monto_total, 0, '', '.') }}"  autocomplete=off class="form-control input-md monto_sub_total text-center" id="monto_sub_total"  readonly="">
            </td> 
            <!--
            <td colspan="1"> 
                {{-- {!! Form::normalInput('monto_total', '&thinsp;', $errors, null, ['readonly' => '','style' => 'background-color:white; border:0px;text-align:center', 'tabIndex' => "-1"]) !!}  --}}
            </td> 
            -->
        </tr> 
        
        </tfoot> 
    </table>
</div>

<div class="box-body footer">

    {!! Form::label('monto_total_letras', 'Total a Pagar') !!}
    {!! Form::text('monto_total_letras', isset($facturaventa->venta)?$facturaventa->venta->monto_total_letras:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
    <br>
    <div class="row">

        <div class="col-sm-4 text-center">
            {!! Form::label('total_iva_5', 'IVA 5%', array('class' => 'text-center')) !!}
            {!! Form::text('total_iva_5', isset($facturaventa->venta)?$facturaventa->venta->total_iva_5:null, array('class' => 'form-control text-center', 'readonly' => '', 'tabIndex' => "-1")) !!}
        </div>
        
        <div class="col-sm-4 text-center">
            {!! Form::label('total_iva_10', 'IVA 10%', array('class' => 'text-center')) !!}
            {!! Form::text('total_iva_10', isset($facturaventa->venta)?$facturaventa->venta->total_iva_10:null, array('class' => 'form-control text-center', 'readonly' => '', 'tabIndex' => "-1")) !!}
        </div>

        <div class="col-sm-4 text-center">
        {!! Form::label('total_iva', 'IVA Total', array('class' => 'text-center') ) !!}
        {!! Form::text('total_iva', isset($facturaventa->venta)?$facturaventa->venta->total_iva:null, array('class' => 'form-control text-center', 'readonly' => '', 'tabIndex' => "-1")) !!}
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            {!! Form::label("my_label","VISI&Oacute;N LEJANA") !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-center">
            {!! Form::normalInput('ojo_izq', 'Ojo Izquierdo', $errors, isset($facturaventa->venta)?$facturaventa->venta:null, ['class' => 'form-control text-center', 'readonly'=> '']) !!}
        </div>

        <div class="col-md-4 text-center">
            {!! Form::normalInput('ojo_der', 'Ojo Derecho', $errors, isset($facturaventa->venta)?$facturaventa->venta:null, ['class' => 'form-control text-center', 'readonly'=> '']) !!}
        </div>

        <div class="col-md-4 text-center">
            {!! Form::normalInput('distancia_interpupilar', 'Distancia Interpupilar', $errors, isset($facturaventa->venta)?$facturaventa->venta:null, ['class' => 'form-control text-center', 'readonly'=> '']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
             {!! Form::label("my_label","VISI&Oacute;N CERCANA") !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 text-center">
            {!! Form::normalInput('ojo_izq_cercano', 'Ojo Izquierdo', $errors, isset($facturaventa->venta)?$facturaventa->venta:null, ['class' => 'form-control text-center', 'readonly'=> '']) !!}
        </div>

        <div class="col-md-4 text-center">
            {!! Form::normalInput('ojo_der_cercano', 'Ojo Derecho', $errors, isset($facturaventa->venta)?$facturaventa->venta:null, ['class' => 'form-control text-center', 'readonly'=> '']) !!}
        </div>
    </div>
    <br>
    {!! Form::label('observacion', 'Observacion') !!}
    {!! Form::text('observacion', isset($facturaventa->venta)?$facturaventa->venta->observacion_venta:null, array('class' => 'form-control', 'readonly' => '', 'tabIndex' => "-1")) !!}
    <br><br>
    <hr>
    
        <div class="col-md-12">
            <h4><b> Pagos y Asientos:</b></h4>
            <br>
            <br>
        </div>

    <div class="col-md-2">
    </div>
    <div class="col-md-7">
                
                    <table class="table table-bordered table-striped table-highlight table-fixed" >
                        <thead>

                            <tr>
                                <th class="text-center" style="background-color:#3c8dbc; color:#fff">Acciones</th>
                                <th class="text-center" style="background-color:#3c8dbc; color:#fff">Pagos</th>
                                <th class="text-center" style="background-color:#3c8dbc; color:#fff">Asientos</th>

                            </tr>
                        </thead>
                        <tbody>
                        @if( isset($facturaventa->venta->pagos) && count($facturaventa->venta->pagos)>0 )
                            @foreach($facturaventa->venta->pagos as $key => $pago)
                                <tr>
                                    <td class="text-center">{!! $pago->delete_button !!}</td>
                                    <td class="text-center">{{ $pago->monto_format }}  </td>  

                                    @if($pago->asientos)
                                        <td class="text-center">
                                            {!! $pago->asientos_links !!}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th class="text-center" colspan="5">SIN PAGOS</th> 
                            </tr>
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th colspan="1" class="text-center" >Total :</th>
                                <td class="text-center">{{ number_format($facturaventa->venta->monto_total, 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th colspan="1" class="text-center">Total Pagado:</th>
                                <td class="text-center">{{ number_format($facturaventa->venta->suma_total_pagos, 0, '', '.') }}</td>
                            </tr>
                            {{-- @ --}}{{-- if($facturaventa->venta->monto_total-$facturaventa->venta->suma_total_pagos > 0) --}}
                            
                            <tr>
                                <th></th>
                                <th colspan="1" class="text-center">Restante a Pagar:</th>
                                <td class="text-center">{{ number_format( ($facturaventa->venta->monto_total-$facturaventa->venta->suma_total_pagos), 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <td colspan="1" class="text-center"><b>Factura N° :</b>{{isset($facturaventa)?$facturaventa->nro_factura:null}}</td>
                                <td colspan="1" class="text-center">   
                                    
                                    @foreach($facturaventa->asientos as $key => $asiento)
                                        <a href="{{ route('admin.contabilidad.asiento.edit', $asiento->id) }}">Asiento Factura ({{ $asiento->operacion }})</a><br><br>
                                    @endforeach
                                     
                                </td>
                            </tr>

                            {{-- @endif --}}
                            <th colspan="3" style="background-color:#3c8dbc; color:#fff">
                                 
                            </th>
                        </tfoot>
                    </table>
                
    </div>
               
                <div class="row">
                    <br>
                    <br>                  
                    <div class="col-md-3">
                        @if(isset($facturaventa->venta) && $facturaventa->venta->suma_total_pagos < $facturaventa->venta->monto_total && isset($facturaventa->venta)?!$facturaventa->venta->anulado:null)
                            <div >
                                <a href="{{ route('admin.pagofacturascredito.pagofacturacredito.create', ['venta_id='.$facturaventa->venta->id.'&caja_id='.$facturaventa->venta->caja_id.'&factura_id='.$facturaventa->id.'&pendiente='.$pendiente]) }}" class="btn btn-primary btn-flat">Agregar Nuevo Pago</a>
                            </div>
                        @endif
                    </div>

                        @if( count($facturaventa->venta->asientos) > 0 )
                            @foreach($facturaventa->venta->asientos as $key => $asiento)
                                <a href="{{ route('admin.contabilidad.asiento.edit', $asiento->id) }}" class="btn btn-primary btn-flat">Asiento Venta ({{ $asiento->operacion }})</a><br><br>
                            @endforeach  
                        @endif
                </div>
            <br><br>
            <hr>
                <div class="col-md-12">
                    <h4><b>Anulacion de Factura:</b></h4>
                    <br>
                    @if(isset($facturaventa->venta)?!$facturaventa->venta->anulado:null)
                        <div class="col-md-10">
                            {!! Form::normalCheckbox('anulado', 'Anular Factura', $errors, isset($facturaventa)?$facturaventa:null, ['style' => 'display:inline']) !!}
                            @endif
                        </div>
                        <div class="col-md-2">
                            @if(!$facturaventa->anulado)
                                {!! Form::button('Actualizar', array('class' => 'btn btn-primary btn-flat', 'id' => 'actualizar_button')) !!}
                        </div>
                    @endif
                </div>
</div>

