{!! Form::normalSelect('anticipo[empleado_id]', "Empleado", $errors, $empleados, (object)['anticipo[empleado_id]' => $anticipo->empleado_id]) !!}
{!! Form::normalInput('anticipo[fecha]', "Fecha", $errors, (object)['anticipo[fecha]' => $anticipo->fecha->format('d/m/Y')], ['class' => "form-control fecha", "required" => "required", "maxlength" => "10"]) !!}
{!! Form::normalInput('anticipo[monto]', "Monto", $errors, (object)['anticipo[monto]' => $anticipo->monto], ['class' => "form-control monto", "required" => "required", "maxlength" => "12"]) !!}
{!! Form::normalInput('anticipo[observacion]', "Observacion", $errors, (object)['anticipo[observacion]' => $anticipo->observacion], ["maxlength" => "255"]) !!}

@if( isset($edit) )
{!! Form::normalCheckbox("anticipo[descontado]", "Descontado", $errors, (object)['anticipo[descontado]' => $anticipo->descontado] ) !!}
@endif