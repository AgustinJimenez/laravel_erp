<div class="box-body">  
        <style type="text/css">
            .align
            {
                text-align: right;
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
                            <th style="background-color:#3c8dbc; color:#fff">Ingresos</th>
                            <th style="background-color:#3c8dbc; color:#fff">Egresos</th>
                            <th style="background-color:#3c8dbc; color:#fff">Diferencia</th>
                        </tr>
                    </thead>
                        @for($i = 0; $i < count($egresos) ; $i++)
                            <tbody class="align">
                                <tr>
                                    <td >{{$meses[$i]}}</td>
                                    <td>{{number_format($ingresos[$i],0,"",".")}}</td>
                                    <td>{{number_format($egresos[$i],0,"",".")}}</td>
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