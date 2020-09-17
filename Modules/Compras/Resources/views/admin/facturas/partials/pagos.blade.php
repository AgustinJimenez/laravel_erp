   

     <div class="row">
     
    </div>
    <hr>
    <label><h4><b>Pagos y Asientos: </b></h4></label>
    <br>
    <br>
<div class="row">   
    

    <div class="col-md-2">
    </div>
    <div class="col-md-7">
        
        <center>
            <table class="table table-bordered table-striped table-highlight table-fixed" style="border: none; width: ">
                <thead>

                    <tr>  
                        <th class="text-center" style="background-color:#3c8dbc; color:#fff">Acciones</th>  
                        <th class="text-center" style="background-color:#3c8dbc; color:#fff">Pagos</th>
                        <th class="text-center" style="background-color:#3c8dbc; color:#fff">Asientos</th>
                       {{--  <th class="text-center">Acciones</th> --}}
                    </tr>

                </thead>

                <tbody>
                    
                    @if( count($compra->pagos)>0 )
                    @foreach($compra->pagos as $key => $pago)

                        <tr style="border: none;">

                            <td class="text-center">{!! $pago->delete_button !!}</td>

                            <td class="text-center">{{ $pago->format('monto','number') }}</td>
               
                            @if(isset($autorizar))
                                @foreach($pago->asientos as $key2 => $asiento)
                                    <td class="text-center"><a href="{{ route('admin.contabilidad.asiento.edit', $asiento->id) }}">-Asiento de {{ $asiento->operacion }}</a></td>
                                @endforeach
                            @endif

                        </tr>

                    @endforeach                   
                    @endif
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="1" class="text-center"></th>
                        <th colspan="1" class="text-center">Total :</th>
                        <td class="text-center">{{ $compra->format('monto_total', 'number') }}</td>
                    </tr>
                    <tr>
                        <th colspan="1" class="text-center"></th>
                        <th colspan="1" class="text-center">Total Pagado:</th>
                        <td class="text-center">{{ $compra->format('suma_total_pagos', 'number') }}</td>
                    </tr>

                    @if( ($compra->restante_pagar) > 0)
                    
                        <tr>
                            <th colspan="1" class="text-center"></th>
                            <th colspan="1" class="text-center">Restante a Pagar:</th>
                            <td class="text-center">{{ $compra->format('restante_pagar', 'number') }}</td>
                        </tr>

                    @endif
                    <tr>
                            <td colspan="1" class="text-center"></td>
                            <td colspan="1" class="text-center"><b>N° Factura :</b>{{$compra->nro_factura}}</td>
                            <td class="text-center">
                            @if(isset($autorizar))
                                @if($compra->asiento_edit_routes)
                                    @foreach($compra->asiento_edit_routes as $key => $route)
                                        {{-- <td class="btn btn-primary btn-flat"> --}}
                                        <a href="{{ $route }}">Asiento de Factura({{ $compra->asientos[$key]->operacion }})<br></a>
                                        {{-- </td> --}}
                                    @endforeach
                                @endif
                            @endif 
                            </td>
                        </tr>

                    <th colspan="3" style="background-color:#3c8dbc; color:#fff"></th>
                </tfoot>
            </table>
        </center>
        <div class="col-md-2">
             @if( !$compra->anulado && $compra->restante_pagar > 0 )

            <div align="center">
                <a href="{{ route('admin.compras.compra.pago_create', [$compra->id]) }}" class="btn btn-primary btn-flat">Agregar Nuevo Pago</a>
            </div>

        @endif
        </div>

    </div>
    <div class="col-md-3">
    </div>
</div>
    <div class="row">
    <div class="col-md-2">
    </div>
        
        
 
        <br>    
        <br>    
        <br>

        <hr>

        <div class="col-md-12">
        
        @if(!$compra->anulado)
            <label><h4><b>Anulacion de Factura: </b></h4></label>
                {!! Form::open(['route' => ['admin.compras.compra.factura_update', $compra->id], 'method' => 'post']) !!}

                <div class="col-md-10">
                    {!! Form::normalCheckbox('anulado', 'Anular Factura', $errors, $compra, ['style' => 'display:inline']) !!}
                </div>

                <div class="col-md-2">
                        {!! Form::submit('Actualizar', array('class' => 'btn btn-primary btn-flat')) !!}
                </div>

                {!! Form::close() !!}
        
        @endif
        </div>
    </div>