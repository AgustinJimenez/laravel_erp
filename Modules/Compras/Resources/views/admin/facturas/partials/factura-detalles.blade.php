<div class="box-body detalle div_tabla"> 
    <table id="tabla_factura" class="table table-bordered table-striped table-highlight table-fixed"> 
        <thead> 
            <tr> 
                <th class="col-sm-1 text-center">Cantidad</th> 
                <th class="col-sm-4 text-center">Descripcion</th> 
                <th class="col-sm-1 text-center">IVA</th> 
                <th class="col-sm-1 text-center">P. Unt.</th> 
                <th class="col-sm-2 text-center">Total</th> 
            </tr> 
        </thead> 
        <?php $c = 0;?> 
        <tbody id="factura_detalles">  

            @foreach($compra->detalles as $key => $detalle) 
                <tr id="{{ 'fila'.$key }}" class="fila"> 

                    <td class="col-sm-1"> 
                        {!! Form::normalInput('cantidad', '&thinsp;', $errors, isset($detalle->cantidad)?(object)['cantidad' => $detalle->wformat('cantidad') ]:'', ['style' => 'text-align:center', 'id'=> 'cantidad', 'required' => '', 'disabled' => '']) !!} 
                                                                             
                    </td> 

                    <td class="col-sm-4"> 
                        {!! Form::normalInput('descripcion', '&thinsp;', $errors, isset($detalle->descripcion)?(object)['descripcion' => $detalle->descripcion]:'', ['style' => 'text-align:center', 'id'=> 'descripcion', 'disabled' => '']) !!} 
                    </td> 

                    <td class="col-sm-1"> 
                        {!!  
                            Form::select('iva[]',[ 
                                                    '0' => 'excenta', 
                                                    '5' => '5%', 
                                                    '10' => '10%' 

                                                 ], isset($detalle->iva)?$detalle->iva:'',  

                            ['class' => 'form-control iva', 'id' => 'iva', 'disabled' => '', 'style' => 'text-align:center']) 
                        !!} 
                     
                    </td> 

                    <td class="col-sm-2"> 
                        {!! Form::text('precio_unitario[]',isset($detalle->precio_unitario)?$detalle->precio_unitario:'', array('class' => 'form-control input-md precio_unitario', 'id' => 'precio_unitario', 'required' => '', 'disabled' => '', 'style' => 'text-align:center')) !!} 
                    </td> 

                    <td class="col-sm-2"> 
                        {!! Form::text('sub_total[]',null, array('class' => 'form-control input-md text-center sub_total', 'id' => 'sub_total', 'readonly' => '', 'tabIndex' => "-1", 'style' => 'text-align:center')) !!} 
                    </td> 
                    <!--
                    <td class="col-sm-2"> 
                        {!! Form::text('total[]',null, array('class' => 'form-control input-md text-center total', 'id' => 'total', 'readonly' => '', 'tabIndex' => "-1", 'style' => 'text-align:center')) !!} 
                    </td> 
                    -->

                </tr> 

            @endforeach 
        </tbody>
        <tfoot> 
        <tr> 
            <th colspan="4" class="text-right">{!! Form::label('', 'Monto total', array('class' => 'control-label')) !!}</th> 
            <td colspan="1"> 
                {!! Form::normalInput('monto_sub_total', '&thinsp;', $errors, (object)['monto_sub_total' => $compra->format('monto_total', 'number')], ['readonly' => '','style' => 'background-color:white; border:0px;text-align:center', 'tabIndex' => "-1"]) !!} 
            </td> 
            <!--
            <td colspan="1"> 
                {!! Form::normalInput('monto_total', '&thinsp;', $errors, $compra, ['readonly' => '','style' => 'background-color:white; border:0px;text-align:center', 'tabIndex' => "-1"]) !!} 
            </td> 
            -->
        </tr> 
        </tfoot> 
    </table>
</div>