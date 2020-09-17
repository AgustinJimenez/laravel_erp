<div class="box box-primary">
    <div class="box-header">
        
        {!! Form::open(['route' => ['admin.compras.compra.reporte_gastos_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
        <div class="row">
            <div class="col-md-2">
            <table>
                <tr>
                <td>{!! Form::normalInput('fecha_inicio', 'Fecha Inicio', $errors, null) !!}</td>
                <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
                </tr>
            </table>   
            </div >

            <div class="col-md-2">
            <table>
                <tr>
                <td>{!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, null) !!}</td>
                <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
                </tr>
            </table>   
            </div >
            
           {{--  <div class="col-md-2">
                {!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, null) !!}
                {!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}
            </div > --}}

            <div class="col-md-2">
                <br>
                <a class="btn btn-flat form-control btn-success" id="excel-button-export">Exportar a Excel</a>
            </div>
            <div class="col-md-2 text-center">
                {!! Form::label('sum_total_pagado_salarios', 'Total Pago de Salarios', array('class' => 'sum_total_pagado_salarios')) !!}
                <div class="text-center"><strong><p id="sum_total_pagado_salarios"></p></strong></div>
            </div>

            <div class="col-md-2 text-center">
                {!! Form::label('sum_total_pagado_ips', 'Total Pago por IPS', array('class' => 'sum_total_pagado_ips')) !!}
                <div class="text-center"><strong><p id="sum_total_pagado_ips"></p></strong></div>
            </div>

            <div class="col-md-2 text-center">
                {!! Form::label('sum_total_pagado', 'Total General Pagado', array('class' => 'sum_total_pagado')) !!}
                <div class="text-center"><strong><p id="sum_total_pagado"></p></strong></div>
            </div>
        </div>
        <br>
        {!! Form::close() !!}

        {!! Form::open(['route' => ['admin.compras.compra.reporte_xls'], 'method' => 'get', 'id' => 'search-form-xls']) !!}
        <div class="col-md-2" style="display: none;">
            {!! Form::normalInput('fecha_inicio2', 'Fecha Inicio', $errors, null) !!}
        </div >
        <div class="col-md-2 text-center" style="display: none;">
            <input type="text" name="categoria" value="{{$categorias}}"></input>
            
        </div>
        <div class="col-md-2" style="display: none;">
            {!! Form::normalInput('fecha_fin2', 'Fecha Fin', $errors, null) !!}
            {!! Form::normalInput('download_xls', 'download_xls', $errors, (object)['download_xls' => 'yes']) !!}
        </div >
        {!! Form::close() !!}
    </div>
</div>