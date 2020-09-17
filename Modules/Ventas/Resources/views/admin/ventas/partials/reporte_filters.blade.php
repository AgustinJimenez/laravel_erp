<div class="box box-primary">
    <div class="box-header">
        {!! Form::open(['route' => ['admin.ventas.venta.reporte_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
            <div class="row">
            
                <div class="col-md-2">
                <table>
                <tr>
                    <td>{!! Form::normalInput('fecha_inicio', 'Fecha Inicio', $errors, $first_day_month) !!}</td>
                    <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
                </tr>
                </table>
                </div >

                <div class="col-md-2">
                <table>
                <tr>
                    <td>{!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, $actual_date) !!}</td>
                    <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
                </tr>
                </table>
                </div >

{{-- 
                <div class="col-md-2">
                    {!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, null) !!}
                    {!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}
                </div >
 --}}
                <div class="col-md-3">
                    <br>
                    <a class="btn btn-flat form-control btn-success" id="excel-button-export">Exportar Excel</a>
                </div>

                 <div class="col-md-3">
                    <br>
                    <a class="btn btn-flat form-control btn-success" id="excel-button-export-with-detalles">Exportar Excel con Detalles</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Monto Total General', array('class' => '')) !!}
                    <div class="text-center"><strong><p id="sum_monto_total"></p></strong></div>
                    
                </div>

                <div class="col-md-2 text-center">
                    {!! Form::label('sum_total_pagado', 'Total General Pagado', array('class' => '')) !!}
                    <div class="text-center"><strong><p id="sum_total_pagado"></p></strong></div>
                </div>

                <div class="col-md-2 text-center">
                    {!! Form::label('total_ganancia', 'Total de Ganancias', array('class' => '')) !!}
                    <div class="text-center"><strong><p id="total_ganancia"></p></strong></div>
                </div>

            </div>
            <br>
        {!! Form::close() !!}

        {!! Form::open(['route' => ['admin.ventas.venta.reporte_xls'], 'method' => 'get', 'id' => 'search-form-xls']) !!}
            <div class="col-md-2" style="display: none;">
                {!! Form::normalInput('fecha_inicio2', 'Fecha Inicio', $errors, null) !!}
            </div >

            <div class="col-md-2" style="display: none;">
                {!! Form::normalInput('fecha_fin2', 'Fecha Fin', $errors, null) !!}
                {!! Form::normalInput('download_xls', 'download_xls', $errors, (object)['download_xls' => 'yes']) !!}
            </div >

        {!! Form::close() !!}
    </div>

</div>