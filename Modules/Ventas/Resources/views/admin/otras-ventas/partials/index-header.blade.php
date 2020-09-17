{!! Form::open(['route' => ['admin.ventas.otras_ventas.index_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
    <div class="row">

        <div class="col-sm-2 col-xs-2">
            <table>
                <tr>
                    <td> 
                        {!! Form::normalInput('fecha_inicio', 'F.I Venta', $errors, null, array('placeholder' => 'Fecha Inicio')) !!}
                    </td>
                    <td>
                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_inicio"></i>
                    </td>
                </tr>
            </table> 
        </div >

        <div class="col-sm-2 col-xs-2">
            <table>
                <tr>
                    <td> 
                        {!! Form::normalInput('fecha_fin', 'Fecha Fin Venta', $errors, null) !!}
                    </td>
                    <td>
                        <i class="glyphicon glyphicon-trash btn btn-flat btn-link" id="borrar_fecha_fin"></i>
                    </td>
                </tr>
            </table>                      
        </div>

         <div class="col-sm-2 col-xs-2">
            {!! Form::normalInput('nro_factura', 'Nro de Factura:', $errors, null) !!}
        </div>

        <div class="col-sm-2 col-xs-2">
            {!! Form::normalInput('razon_social', 'Razon Social:', $errors, null) !!}
        </div>

        <div class="col-sm-2 col-xs-2">
            {!! Form:: normalSelect('anulado', 'Anulado', $errors,[0=>'NO',1=>'SI'], null, ['id'=>'anulado'] ) !!}
        </div>
        

    </div>
    <br>
{!! Form::close() !!}
