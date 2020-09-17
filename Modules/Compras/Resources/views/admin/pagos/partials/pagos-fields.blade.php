{!! Form::open(['route' => ['admin.compras.compra.pago_store'], 'method' => 'post', 'id' => 'formulario']) !!}
    {!! Form::hidden('compra_id', $compra->id) !!}
    {!! Form::hidden('caja_id', $caja->id) !!}

    <div class="box-body">

        <div class="row">

            <div class="col-md-2">
                <strong><p>Total a Pagar:</p></strong> 
                <strong><p>Suma Total de Pagos:</p></strong> 
                <strong><p>Restante a Pagar:</p></strong> 
                <strong><p>Vuelto:</p></strong> 
            </div>

            <div class="col-md-1">
                <p id="monto_total">{{ $compra->format('monto_total', 'number') }}</p>
                
                <p id="suma_total_pagos">{{ $compra->format('suma_total_pagos', 'number') }}</p>

                <p id="resta">{{ $compra->format('restante_pagar', 'number') }}</p>
                
                {{-- <p id="restante">{{ $compra->format('restante_pagar', 'number') }}</p> --}}

                <p id="vuelto">0</p>
            </div>

        </div>
        <br><br>
        <div class="row">

        	<div class="col-md-3">
        	    {!! Form::normalInput('fecha','Fecha', $errors, $fecha) !!}
        	</div>

        	<div class="col-md-3">
            	{!! Form::normalInput('monto','Monto', $errors, null) !!}
            </div>

            <div class="col-md-3">
                {!! Form:: normalSelect('forma_pago', 'Forma de Pago:', $errors, ['efectivo'=>'Efectivo', 'cheque'=>'Cheque', 'tarjeta_credito' => 'Tarjeta de Credito', 'tarjeta_debito' => 'Tarjeta de Debito']) !!}
            </div>
                
        </div>
        <div class="row">
            <div class="col-md-3">
                {!! Form::normalInput('deber', ' Cta. Debe:', $errors, (object)['deber' => $deber->codigo.' -'.$deber->nombre ], ['required' => ''] ) !!}
                <input type="hidden" name="deber_id" class="ui-autocomplete-input deber_id" id="deber_id" value="{{ $deber->id }}">
            </div>
            <div class="col-md-3">
                {!! Form::normalInput('haber', ' Cta. Haber:', $errors, (object)['haber' => $haber->codigo.' -'.$haber->nombre ], ['required' => ''] ) !!}
                <input type="hidden" name="haber_id" class="ui-autocomplete-input haber_id" id="haber_id" value="{{ $haber->id }}">
            </div>
        </div>
        <br>
        <br>

        {!! Form::submit('Agregar Pago', array('class' => 'btn btn-primary btn-flat')) !!}
    </div>
    
{!! Form::close() !!}