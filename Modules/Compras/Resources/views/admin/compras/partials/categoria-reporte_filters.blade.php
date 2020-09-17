<div class="box box-primary">
    <div class="box-header">
        {!! Form::open(['route' => ['admin.compras.compra.categorias_reporte_gastos_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
            <div class="row">

                <div class="col-md-2">
                    {!! Form::normalInput('fecha_inicio', 'Fecha Inicio', $errors, null) !!}
                    {!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}
               
                </div >

                <div class="col-md-2">
                    {!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, null) !!}
                    {!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}
                </div >
{{--                 <div class="col-md-2">
                    <br>
                    <a href="{{ route('admin.compras.compra.categorias_reporte_xls', ['fecha_inicio' => 'A', 'fecha_fin' => 'B']) }}" class="btn btn-flat form-control btn-success" id="excel-button-export">Exportar a Excel</a>
                </div>
 --}}

                <div class="col-md-2">
                    <br>
                    <a class="btn btn-flat form-control btn-success" id="excel-button-export">Exportar a Excel</a>
                </div>

                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Monto Total General', array('class' => '')) !!}
                    <div class="text-center"><strong><p id="sum_monto_total"></p></strong></div>
                    
                </div>

                <div class="col-md-2 text-center">
                    {!! Form::label('sum_total_pagado', 'Total General Pagado', array('class' => '')) !!}
                    <div class="text-center"><strong><p id="sum_total_pagado"></p></strong></div>
                </div>

            </div>
            <br>
        {!! Form::close() !!}

        {!! Form::open(['route' => ['admin.compras.compra.categorias_reporte_xls'], 'method' => 'get', 'id' => 'search-form-xls']) !!}
            <div class="col-md-2" style="display: none;">
                {!! Form::normalInput('fecha_inicio2', 'Fecha Inicio', $errors, null) !!}
            </div >

            <div class="col-md-2" style="display: none;">
                {!! Form::normalInput('fecha_fin2', 'Fecha Fin', $errors, null) !!}
                {!! Form::normalInput('download_xls', 'Download', $errors, (object)['download_xls' => 'yes']) !!}
            </div >

        {!! Form::close() !!}
    </div>

</div>