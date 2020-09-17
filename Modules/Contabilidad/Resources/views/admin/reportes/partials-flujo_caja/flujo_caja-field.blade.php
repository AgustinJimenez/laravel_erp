<div class="box-body">  
        <style type="text/css">
            .display-no
            {
                display: none;
            }
        </style>
        <div class="box-header">
                <table class="data-table table table-bordered table-hover display nowrap" id="table" class="display nowrap" cellspacing="0" width="100%">
                    <thead>

                        <tr>
                            <th colspan="4" style="background-color:#F2F2F2"><center><h3>Año {{$anho}}</h3></center></th>
                        </tr>
                        <tr>
                            
                            <th style="background-color:#3c8dbc; color:#fff">Mes</th>
                            <th style="background-color:#3c8dbc; color:#fff">Entrada</th>
                            <th style="background-color:#3c8dbc; color:#fff">Salida</th>
                            <th style="background-color:#3c8dbc; color:#fff">Diferencia</th>
                        </tr>
                    </thead>
                        @for($i = 0; $i < count($salidas) ; $i++)
                            <tbody>
                                <tr>
                                    <td >{{$meses[$i]}}</td>
                                    <td>{{number_format($entradas[$i],0,"",".")}}</td>
                                    <td>{{number_format($salidas[$i],0,"",".")}}</td>
                                    <td>{{number_format($diferencia[$i],0,"",".")}}</td>

                                </tr>
                            </tbody>
                        @endfor
                    <tfoot>
                    <tr>
                        <th style="background-color:#3c8dbc; color:#fff"></th>
                        <th style="background-color:#3c8dbc; color:#fff"></th>
                        <th style="background-color:#3c8dbc; color:#fff"></th>
                        <th style="background-color:#3c8dbc; color:#fff"></th>

                    </tr>
                    </tfoot>
                </table>
        </div>
    
</div>