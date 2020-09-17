<table class="data-table table table-bordered table-hover">

    <div class="col-md-3" style="float: right; margin-right: 30px;" id="saldo_acumulado_div">
        {!! Form::normalInput('saldo_acumulado', 'Saldo Acumulado hasta el '.$fecha_inicio, $errors, (object)['saldo_acumulado' => $saldo_acumulado], ['readonly' => '', 'disabled' => 'true']) !!}
    </div>
    <thead>
        <tr>
            <th class="table-style">Fecha</th>
            <th class="table-style">Operación</th>
            <th class="table-style">Observación</th>
            <th class="table-style">Debe</th>
            <th class="table-style">Haber</th>
            <th class="table-style">Saldo</th>
        </tr>
    </thead>
    <tbody>

        <tr>

            <td></td>

            <td></td>

            <td></td>

            <td></td>

            <td></td>

            <td></td>

        </tr>

    </tbody>
    <tfoot>
        <tr>
            <th class="table-style">Fecha</th>
            <th class="table-style">Operación</th>
            <th class="table-style">Observación</th>
            <th class="table-style">Debe</th>
            <th class="table-style">Haber</th>
            <th class="table-style">Saldo</th>
        </tr>
    </tfoot>
</table>