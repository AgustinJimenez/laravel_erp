<div class="box-body">

    <div class="row">

        <div class="col-md-2">
            <strong><p>Total a Pagar:</p></strong> 
            <strong><p>Suma Total de Pagos:</p></strong> 
            <strong><p>Restante a Pagar:</p></strong> 
            <strong><p>Vuelto:</p></strong> 
        </div>

        <div class="col-md-1">
            <p id="monto_total">{{ isset($pagofacturacredito)?$pagofacturacredito->venta->monto_total_format: $factura_venta->venta->monto_total_format }}</p>
            
            <p id="suma_total_pagos">{{ isset($pagofacturacredito)?$pagofacturacredito->venta->suma_total_pagos_format: $factura_venta->venta->suma_total_pagos_format }}</p>

            <p id="resta">{{ isset($pagofacturacredito)?$pagofacturacredito->venta->restante_a_pagar_format: $factura_venta->venta->restante_a_pagar_format }}</p>
            
            <input type="hidden" name="venta_id" value="{{$venta_id}}">
            {{-- <p id="restante">{{ $factura_venta->venta->restante_a_pagar_format }}</p> --}}

            <p id="vuelto">0</p>
        </div>

    </div>
    <br><br>
    <div class="row">

    	<div class="col-md-3">
    	    {!! Form::normalInput('fecha','Fecha', $errors, isset($pagofacturacredito)?$pagofacturacredito:(object)['fecha' => $fecha], ['required' => '']) !!}
    	</div>

    	<div class="col-md-3">
        	{!! Form::normalInput('monto','Monto', $errors, isset($pagofacturacredito)?$pagofacturacredito:(object)['monto' => '0'], ['required' => '']) !!}
        </div>

        <div class="col-md-3">
            {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito']) !!}
        </div>

       {{--  {!! Form::hidden('caja_id', $caja_id) !!}
        {!! Form::hidden('venta_id', $venta_id) !!}
        {!! Form::hidden('factura_id', $factura_id) !!}
        {!! Form::hidden('pendiente', $pendiente) !!} --}}

    </div>


</div>
