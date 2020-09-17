	<div class="row">
	
		{!! Form::open(array('route' => ['admin.contabilidad.cuenta.historial_ajax'],'method' => 'post', 'id' => 'search-form', 'target=' => '_blank')) !!}
			<div class="col-md-2">
	            <table>
	                <tr>
	                    <td>
	                        {!! Form::normalInput('fecha_inicio', 'Fecha Inicio:', $errors, (object)['fecha_inicio' => $fecha_inicio]) !!}
	                    </td>
	                    
	                </tr>
	            </table>
	        </div>

			<div class="col-md-2">
	            <table>
	                <tr>
	                    <td>
	                        {!! Form::normalInput('fecha_fin', 'Fecha Fin:', $errors, (object)['fecha_fin' => $fecha_fin]) !!}
	                    </td>
	                    
	                </tr>
	            </table>
	        </div>
        {!! Form::close() !!}
	
	<div class="col-md-6">
	</div>
	{!! Form::open(array('route' => ['admin.contabilidad.cuenta.historial_excel'],'method' => 'post', 'id' => 'form_report_excel', 'target=' => '_blank')) !!}
		<div class="col-md-2">
	    {!! Form::hidden('fecha_inicio_excel') !!} {!! Form::hidden('fecha_fin_excel') !!}	{!! Form::hidden('cuenta_id', $cuenta->id) !!} {!! Form::hidden('saldo_acumulado_excel', $saldo_acumulado) !!}

	        <button type="submit" class="btn btn-success" >
	            <i class="fa fa-book"></i> {{ trans('Exportar a Excel') }}
	        </button>

	{!! Form::close() !!}
			

	    </div>
	</div>	