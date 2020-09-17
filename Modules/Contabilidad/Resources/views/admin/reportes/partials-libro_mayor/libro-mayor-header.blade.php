{!! Form::open(array('route' => ['admin.contabilidad.reportes.libro_mayor_index'],'method' => 'post', 'id' => 'search-form')) !!}
    
    @if( !isset($hay_cuenta) )
        <div class="col-md-2">
            <label for="razon_social" class="control-label" >Codigo:   </label>
            <input type="text" class="form-control input-sm codigo" name="codigo" id="codigo" value="" >
        </div>

        <div class="col-md-2">
            <label for="marca">Tipo: </label>
            <select class="form-control tipo" id="tipo" name="tipo">
                <option value='' selected>--</option>
                @foreach($tipos as $tipo)
                    <option value='{{ $tipo->nombre }}'>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="razon_social" class="control-label" >Nombre:   </label>
            <input type="text" class="form-control input-sm nombre" name="nombre" id="nombre" value="" >
        </div>
    @endif

    <div class="col-md-2">
        <table>
            <tr>
                <td>
                    {!! Form::normalInput('fecha_desde', 'Fecha Desde:', $errors, (object)['fecha_desde' => "01/01/".Session::get('ejercicio')]) !!}
                </td>
                <td>
                    <button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_desde" style=""><i class="fa fa-trash" style=""></i></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-2">
        <table>
            <tr>
                <td>
                    {!! Form::normalInput('fecha_hasta', 'Fecha Hasta:', $errors, (object)['fecha_hasta' => "31/12/".Session::get('ejercicio')]) !!}
                </td>
                <td>
                    <button class="btn btn-flat form-control" data-toggle="modal" id="borrar_fecha_hasta" style=""><i class="fa fa-trash" style=""></i></button>
                </td>
            </tr>
        </table>
    </div>

{!! Form::close() !!}
    <div class="col-md-2">
    
    
        {!! Form::open(array('route' => ['admin.contabilidad.reportes.libro_mayor_xls'],'method' => 'post', 'id' => 'form_report_xls', 'target=' => '_blank')) !!}

            
                {!! Form::hidden('fecha_inicio_xls') !!} {!! Form::hidden('fecha_fin_xls') !!}
                {!! Form::hidden('codigo_xls') !!}
                {!! Form::hidden('tipo_xls') !!}
                {!! Form::hidden('nombre_xls') !!}

                @if(isset($hay_cuenta) )
                    {!! Form::hidden('cuenta_id_xls', $cuenta->id) !!}
                @endif
            
                <button type="submit" class="btn btn-success" >
                    <i class="fa fa-book"></i> {{ trans('Exportar a Excel') }}
                </button>

        {!! Form::close() !!}

        @if(isset($hay_cuenta) )
            {!! Form::hidden('cuenta_id', $cuenta->id) !!}
        @endif

    </div>