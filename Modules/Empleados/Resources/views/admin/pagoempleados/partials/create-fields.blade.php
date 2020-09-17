<style type="text/css">
    .anticipo-checkbox 
    {
        transform: scale(1.7);
    }
   

</style>
<div class="box-body">
	<div class="form-group " style="display: none;">
		<label for="id">empleado_id</label>
		<input class="form-control" placeholder="empleado_id" name="empleado_id" type="text" value="{{ $empleado->id }}" id="empleado_id" readonly>
	</div>

	<div class="form-group " style="display: none;">
		<label for="id">usuario_sistema_id</label>
		<input class="form-control" placeholder="usuario_sistema_id" name="usuario_sistema_id" type="text" value="{{ $usuario->id }}" id="usuario_sistema_id" readonly>
	</div>
    <div class="row">
        <div class="col-md-3">
        {!! Form::normalInput('fecha', 'Fecha', $errors, $fecha) !!}
        </div>
    </div>
    <br>
    <h4><b>Empleado:</b> </h4>
    <hr>
    @if( count($empleado->anticipos) and $empleado->anticipos->where('destontado', false))
    <div class="row">
        <div class="col-md-7">
            <br>
            
                <table class="table ">
                    <thead class="btn-primary">
                        <tr>
                            <th colspan="4" class="text-center">
                                ANTICIPOS
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center">SELECCIONAR</th>
                            <th>FECHA</th>
                            <th>MONTO</th>
                            <th>OBSERVACION</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($empleado->anticipos as $anticipo)
                        @if(!$anticipo->descontado)
                            <tr>
                                <td class="text-center">
                                    {!! Form::checkbox('anticipo['.$anticipo->id.']', null ,true, ['class' => 'anticipo-checkbox']) !!}
                                </td>
                                <td>
                                    {!! Form::label('anticipo-fecha-'.$anticipo->id, $anticipo->fecha->format('d/m/Y'), array('class' => 'mylabel')) !!}
                                </td>
                                <td>
                                    {!! Form::label('anticipo-monto'.$anticipo->id, $anticipo->monto, array('class' => "monto")) !!}
                                </td>
                                <td>
                                    {!! Form::label($anticipo->observacion, $anticipo->observacion , array('class' => "obs")) !!}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="1" class="btn-primary"></th>
                        <th colspan="3" class="btn-primary" id="suma-total-montos">
                        </th>
                    </tfoot>
                </table>
                
        </div>
        @endif
        <div class="col-md-5">
        	{!! Form::normalInput('salario', 'Salario', $errors, $empleado, ['readonly'=>'', 'salario-original' => $empleado->salario]) !!}
            {!! Form::normalInput('extra', 'Extra', $errors,null,['required'=>'']) !!}
            {!! Form::normalInput('descuento_ips', 'Descuento IPS (9%)', $errors, null, ['readonly'=>'']) !!}
            {!! Form::normalInput('total_pagar_empleado', 'Total a entregar al Empleado:', $errors,null, ['readonly'=>'']) !!}

        </div>
    </div>

    <br><br>
    <h4><b>Empresa:</b> </h4>
    <hr>
    

    <div class="row">
        <div class="col-md-5">
            {!! Form::normalInput('monto_ips', 'Aporte Patronal IPS (16,5%)', $errors, null,['readonly'=>'']) !!}
        </div>
        <div class="col-md-5">
            {!! Form::normalInput('total_pagar', 'Gasto Total por Empleado', $errors,null,['readonly'=>'']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::normalInput('observacion', 'Observacion', $errors) !!}
        </div>
    </div>

	
</div>
<style type="text/css">
        
        #cke_1_top
        {
            display: none;
        }

        #cke_1_bottom
        {
            display: none;
        }
        
    </style>
