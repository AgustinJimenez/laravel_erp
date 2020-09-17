<div class="row">

	{!! Form::open(array('route' => ['admin.contabilidad.reportes.flujo_efectivo_ajax'],'method' => 'post', 'id' => 'search-form')) !!}

		<div class="col-md-2">
            <table>
                <tr>

                    <td>
                        {!! Form::normalInput('fecha_inicio', 'Fecha Inicio', $errors, (object)['fecha_inicio' => $fecha_inicio_mes]) !!}
                    </td>
                    
                </tr>
            </table>
        </div>

		<div class="col-md-2">
            <table>
                <tr>

                    <td>
                        {!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, (object)['fecha_fin' => $fecha_actual]) !!}
                    </td>
                    
                </tr>
            </table>
        </div>

    {!! Form::close() !!}

	<div class="col-md-6"></div>

    <div class="col-md-2">
	{!! Form::open(array('route' => ['admin.contabilidad.reportes.flujo_efectivo_excel'],'method' => 'post', 'id' => 'form_report_excel', 'target=' => '_blank')) !!}
		
	    {!! Form::hidden('fecha_inicio_excel') !!} {!! Form::hidden('fecha_fin_excel') !!}

	        <button type="submit" class="btn btn-success" >
	            <i class="fa fa-book"></i> {{ trans('Exportar a Excel') }}
	        </button>

	{!! Form::close() !!}
		
    </div>
    
</div>	