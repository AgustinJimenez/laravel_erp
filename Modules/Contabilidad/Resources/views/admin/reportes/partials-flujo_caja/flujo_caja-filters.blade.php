<div class="box box-primary">
    <div class="box-header">
        {!! Form::open(['route' => ['admin.compras.compra.reporte_gastos_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
            <div class="row">

                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Total Entrada', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_entradas,0,"",".")}}</p></strong></div>
                    
                </div>

                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Total Salida', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_salidas,0,"",".")}}</strong></div>
                    
                </div>

              {{--   <div class="col-md-2 text-center">
                    {!! Form::label('sum_total_pagado', 'Total General', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_general,0,"",".")}}</p></strong></div>
                </div> --}}



            </div>
            <br>
        {!! Form::close() !!}
        {!! Form::open(['route' => ['admin.compras.compra.reporte_xls'], 'method' => 'get', 'id' => 'search-form-xls']) !!}
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