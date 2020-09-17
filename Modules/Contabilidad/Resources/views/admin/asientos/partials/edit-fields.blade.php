	
	<div class="box-body">
		<div class="row">
		
            <div class="col-md-5">
            	<strong>Creado por: </strong>{{ $asiento->usuario_apellido_nombre() }}
			</div>

			<div class="col-md-5">
				@if($asiento->usuario_apellido_nombre('edit'))
            		<strong>Ult Editado por: </strong>{{ $asiento->usuario_apellido_nombre('edit') }}
            	@endif
			</div>

        </div>
        <hr>
		<div class="row">
			<div class="col-md-2">
				{!! Form::normalInput('fecha', 'Fecha', $errors,$asiento) !!}
			</div>

			<div class="col-md-3">
                {!! Form::normalInput('operacion', 'Operacion', $errors, $asiento) !!}
            </div>

            @if($asiento->entidad)
			<div class="col-md-2 col-md-offset-3">
				<br>	
				{!! $asiento->entidad->factura_button !!}
			</div>
			@endif
		</div>
		
		<br>
		
		{!! Form::normalInput('observacion', 'Comentario', $errors,$asiento) !!}
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
				
				<tbody>
				@foreach($detalles as $detalle)
				<tr>
					<td class="col-sm-2 input-group">
						<div id="divCuenta" class="form-group divCuenta" >
							<input type="text" class="form-control input-sm cuenta_nombre" name="cuenta_nombre[]" id="cuenta_nombre" value="{{$detalle->cuenta->nombre}}" placeholder="Nombre Cuenta" required="">
							<input type="text" class="form-control input-sm  cuenta_id" name="cuenta_id[]" id="cuenta_id" value="{{$detalle->cuenta->id}}" placeholder="id" readonly style="height:20px;width:40px;display:none;">
							<input type="text" class="form-control input-sm " name="detalle_id[]" id="" value="{{$detalle->id}}" placeholder="id" readonly style="height:20px;width:40px;display:none;">
							<input type="text" class="form-control input-sm eliminar" name="eliminar[]" id="eliminar" value="0" placeholder="id" readonly style="height:20px;width:40px;display:none;">
						</div>
					</td>
					<td class="col-sm-3 input-group">
						<div id="divObservacion" class="form-group divObservacion" >
							<input type="text" class="form-control input-sm observacion" name="observacion_detalle[]" id="observacion" value="{{$detalle->observacion}}" placeholder="Observacion">
						</div>
					</td>
					<td class="col-sm-1 input-group">
						<div id="divDebe" class="form-group divDebe" >
							<input type="text" class="form-control input-sm debe" name="debe[]" id="debe" value="{{$detalle->debe}}" placeholder="Debe" required="">
						</div>
					</td>
					<td class="col-sm-1 input-group">
						<div id="divHaber" class="form-group divHaber" >
							<input type="text" class="form-control input-sm haber" name="haber[]" id="haber" value="{{$detalle->haber}}" placeholder="Haber" required="">
						</div>
					</td>
					<td class="col-sm-1" >
						<p  class="btn btn-danger remove_field_old" style="width:80%">Eliminar</p>
					</td>
				</tr>
				@endforeach
				<?php

					$row ='<td class="col-sm-2 input-group">
						<div id="divCuenta" class="form-group divCuenta" >
							<input type="text" class="form-control input-sm cuenta_nombre" name="cuenta_nombre[]" id="cuenta_nombre" value="" placeholder="Nombre Cuenta" required="">
							<input type="text" class="form-control input-sm  cuenta_id" name="cuenta_id[]" id="cuenta_id" value="" placeholder="id" readonly style="height:20px;width:40px;display:none;">
							<input type="text" class="form-control input-sm " name="detalle_id[]" id="" value="0" placeholder="id" readonly style="height:20px;width:40px;display:none;">
							<input type="text" class="form-control input-sm " name="eliminar[]" id="eliminar" value="0" placeholder="id" readonly style="height:20px;width:40px;display:none;">
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
					</td>
					<td class="col-md-1" >
						<p  class="btn btn-danger remove_field" style="width:80%">Eliminar</p>
					</td>';
					
				;?>
				<?php
				$column_action = '<td class="col-sm-1" style="display: none;" >
						<p  class="btn btn-danger remove_field">Eliminar</p>
					</td>';?>

				</tbody>
				<tfoot>
				<tr>
					<th>
						<td>
							<strong style="float: right;">Monto total</strong>
						</td>
						<td>
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
	@include('contabilidad::admin.asientos.asiento-script')