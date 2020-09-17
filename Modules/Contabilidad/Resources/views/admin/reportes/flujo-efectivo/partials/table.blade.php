<table class="data-table table table-bordered table-hover">

    <div class="col-md-3" style="float: right;">
        {!! Form::normalInput('saldo_acumulado', 'Saldo Acumulado hasta el '.$fecha_inicio_mes ,$errors, null, ['readonly' => '', 'disabled' => 'true']) !!}
    </div>

    <thead>
        <tr>
            <th class="table-th-style">Fecha</th>
            <th class="table-th-style">Debe</th>
            <th class="table-th-style">Haber</th>
            <th class="table-th-style">Saldo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>

            <td></td>

            <td></td>

            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="table-th-style">Fecha</th>
            <th class="table-th-style">Debe</th>
            <th class="table-th-style">Haber</th>
            <th class="table-th-style">Saldo</th>
        </tr>
    </tfoot>
</table>