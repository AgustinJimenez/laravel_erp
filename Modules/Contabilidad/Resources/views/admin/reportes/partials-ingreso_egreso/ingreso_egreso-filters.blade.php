<div class="box box-primary">
    <div class="box-header">
        {!! Form::open(['route' => ['admin.compras.compra.reporte_gastos_ajax'], 'method' => 'post', 'id' => 'search-form']) !!}
            <div class="row">

                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Monto Total Ingresos', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_ingreso,0,"",".")}}</p></strong></div>
                    
                </div>

                <div class="col-md-2 text-center">
                    {!!Form::label('sum_monto_total', 'Monto Total Egresos', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_egreso,0,"",".")}}</strong></div>
                    
                </div>

                <div class="col-md-2 text-center">
                    {!! Form::label('sum_total_pagado', 'Total General', array('class' => '')) !!}
                    <div class="text-center"><strong>{{number_format($total_general,0,"",".")}}</p></strong></div>
                </div>
                <div class="col-md-2">
                    {!! Form::button('EXPORTAR A EXCEL', array('class' => 'btn btn-success button-excel')) !!}
                </div>
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

        {!! Form::open(['route' => ['admin.contabilidad.reportes.ingreso_egreso'], 'method' => 'post', 'id' => 'form-excel']) !!}
            {!! Form::hidden('year', $anho ) !!}
            {!! Form::hidden('print_excel', true ) !!}
        {!! Form::close() !!}
    </div>

</div>
<script type="text/javascript">
    $(".button-excel").click(function()
    {
        $("#form-excel").submit();
    });
</script>