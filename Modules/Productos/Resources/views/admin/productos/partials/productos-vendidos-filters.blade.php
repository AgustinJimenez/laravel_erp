{!! Form::open(array('route' => ['admin.productos.producto.productos_vendidos_ajax'],'method' => 'post', 'id' => 'search-form')) !!}

    <div class="row">
        <div class="col-md-2">
        <table>
            <tr>
                <td>{!! Form::normalInput('fecha_inicio', 'Fecha Inicio', $errors, null) !!}</td>
                <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_inicio')) !!}</td>
            </tr>
        </table>
        </div>

        <div class="col-md-2">
        <table>
            <tr>
                <td>{!! Form::normalInput('fecha_fin', 'Fecha Fin', $errors, null) !!}</td>
                <td>{!!Form::button('<i class="fa fa-trash" style=""></i>', array('class' => 'btn btn-flat form-control', 'id' => 'borrar_fecha_fin')) !!}</td>
            </tr>
        </table>
        </div>

        <div class="col-md-2">
            {!! Form::normalInput('producto', 'Producto', $errors, null) !!}
        </div>

        <div class="col-md-2">
            {!! Form::normalSelect('categoria', 'Categoria', $errors, $productos__categoria, ['id' => 'categoria']) !!}
        </div>

        <div class="col-md-2">
            {!! Form::normalSelect('marca', 'Marca', $errors, $productos__marca, ['id' => 'marca']) !!}
        </div>
        <div class="col-md-2">
            <br>
            {!! Form::button('EXPORTAR A EXCEL', array('class' => 'btn btn-success exportar-excel-button')) !!}
        </div>
    </div>

{!! Form::close() !!}

{!! Form::open(['route' => ['admin.productos.producto.productos_vendidos_xls'], 'method' => 'get', 'id' => 'search-form-xls']) !!}
    <div style="display: none;">
        {!! Form::normalInput('fecha_inicio_excel', 'Fecha Inicio', $errors, null) !!}
        {!! Form::normalInput('fecha_fin_excel', 'Fecha Fin', $errors, null) !!}
        {!! Form::normalInput('producto_excel', 'Producto', $errors, null) !!}
        {!! Form::normalInput('categoria_excel', 'Categoria', $errors, null) !!}
        {!! Form::normalInput('marca_excel', 'Marca', $errors, null) !!}
        {!! Form::normalInput('download_xls', 'Fecha Fin', $errors, (object)['download_xls' => 'yes']) !!}
    </div >

{!! Form::close() !!}
<script type="text/javascript">
    $(".exportar-excel-button").click(function()
    {
        $("#fecha_inicio_excel").val( $("#fecha_inicio").val() );
        $("#fecha_fin_excel").val( $("#fecha_fin").val() );
        $("#producto_excel").val( $("#producto").val() );
        $("#categoria_excel").val( $("select[name=categoria]").val() );
        $("#marca_excel").val( $("select[name=marca]").val() );
        $("#search-form-xls").submit();
    });
</script>