<div class="overflow-x:auto;" id="div_tabla">
    <br><br><br><br>
    <table id="tabla_detalle_venta" class="table table-bordered table-striped table-highlight table-fixed tabla_detalle_venta">
        <thead>
            <tr>
                <th class="col-sm-4 text-center">Descripcion</th>
                <th class="col-sm-1 text-center">Cantidad</th>
                <th class="col-sm-1 text-center">IVA</th>
                <th class="col-sm-1 text-center" id="precio_unitario_label">Precio Unitario (Guaranies)</th>
                <th class="col-sm-1 text-center">Sub Total + IVA (Guaranies)</th>
                <th class="col-sm-1 text-center">Accion</th>
            </tr>
        </thead>
        <tbody id="venta_detalle" class="">
            <tr id="0">
                @if(count($errors)>0)
                @foreach(old('cantidad') as $key => $val)
                @if($isProducto)
                <tr>
                    <td class="col-sm-4 input-group {!! $errors->first('producto_id.'.$key,'has-error') !!}">
                        <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="{{ old('descripcion.'.$key) }}" placeholder="Nombre Produto" required="">
                        
                        <div class="seleccionID" id="seleccionID" style="display:noe;">
                            <input type="text" class="" name="producto_id[]" id="producto_id" value="{{ old('producto_id.'.$key) }}" placeholder="p id" readonly style="height:20px;width:20px;display:noe;">
                        </div>
                        <div id="" style="display: noe;" >
                            <input type="text" id="eliminar" value="{{ old('eliminar.'.$key) }}" name="eliminar[]" style="height: 20px; width: 30px;">
                            <input type="text" name="detalle_id[]" value="{{ old('detalle_id.'.$key) }}" style="height: 20px; width: 30px;">
                        </div>
                        {!! $errors->first('producto_id.'.$key, '<p style="font-size: 10px; color:red;">:message</p>') !!}
                    </td>
                    
                    @else
                    <td class="col-sm-4 input-group">
                        <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="{{ old('descripcion.'.$key) }}" placeholder="Descripcion" required = "">
                        <div id="" style="display: noe;" >
                            <input type="text" id="eliminar" value="{{ old('eliminar.'.$key) }}" name="eliminar[]" style="height: 20px; width: 30px;">
                            <input type="text" name="detalle_id[]" value="{{ old('detalle_id.'.$key) }}" style="height: 20px; width: 30px;">
                        </div>
                        
                    </td>
                    
                    @endif
                    <td class="col-sm-2" >
                        <input type="text" name="cantidad[]" class="form-control input-md cantidad" id="cantidad" value="{{ old('cantidad.'.$key ) }}" placeholder="Cantidad" autocomplete=off required/>
                    </td>
                    <td class="col-sm-1" style="display:noe">
                        <select class="form-control iva" name="iva[]" id="iva" >
                            <option value="0" @if(old('iva.'.$key) == 0) selected @else @endif >0%</option>
                            <option value="21" @if(old('iva.'.$key) == 21) selected @else @endif >5%</option>
                            <option value="11" @if(old('iva.'.$key) == 11) selected @else @endif>10%</option>
                        </select>
                    </td>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <input type="text" name="precio_unitario[]" class="form-control input-md precio_unitario" autocomplete=off placeholder="Precio Unitario" id="precio_unitario" value="{{ old('precio_unitario.'.$key) }}" required/>
                        </div>
                    </td>
                    <td class="col-sm-2">
                        <input type="text" name="sub_total[]" class="form-control input-md sub_total" value="{{ old('sub_total.'.$key) }}" placeholder="Sub Total" id="sub_total" readonly="">
                    </td>
                    <td class="col-1" >
                        <p  class="btn btn-danger remove_field_old">Eliminar</p>
                    </td>
                </tr>
                @endforeach
                @else
                @foreach($detalles as $key => $detalle)
                <tr id="{{ $key }}">
                    @if($isProducto)
                    <td class="col-sm-4 input-group">
                        <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="{{ $detalles[$key]->descripcion }}" placeholder="Nombre Produto" required="">
                        
                        <div class="seleccionID" id="seleccionID" style="display:noe;">
                            <input type="text" class="" name="producto_id[]" id="producto_id" value="{{ $detalles[$key]->producto_id }}" placeholder="p id" readonly style="height:20px;width:20px;display:noe;">
                            
                            <div id="" style="display: noe;" >
                                <input type="text" id="eliminar" value="no" name="eliminar[]" style="height: 20px; width: 30px;">
                                <input type="text" name="detalle_id[]" value="{{ $detalles[$key]->id }}" style="height: 20px; width: 30px;">
                            </div>
                        </div>
                    </td>
                    
                    @else
                    <td class="col-sm-4 input-group">
                        <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="{{ $detalles[$key]->descripcion }}" placeholder="Descripcion" required = "">
                        <div id="" style="display: noe;" >
                            <input type="text" id="eliminar" value="no" name="eliminar[]" style="height: 20px; width: 30px;">
                            <input type="text" name="detalle_id[]" value="{{ $detalles[$key]->id }}" style="height: 20px; width: 30px;">
                        </div>
                    </td>
                    
                    @endif
                    <td class="col-sm-2" >
                        <input type="text" name="cantidad[]" class="form-control input-md cantidad" id="cantidad" value="{{ $detalles[$key]->cantidad }}" placeholder="Cantidad" autocomplete=off required/>
                    </td>
                    <td class="col-sm-1" style="display:noe">
                        <select class="form-control iva" name="iva[]" id="iva" >
                            <option value="0" @if($detalle->iva == 'excenta') selected @else @endif >0%</option>
                            <option value="21" @if($detalle->iva == '5') selected @else @endif >5%</option>
                            <option value="11" @if($detalle->iva == '10') selected @else @endif>10%</option>
                        </select>
                    </td>
                    <td class="col-sm-2">
                        <div class="form-group">
                            <input type="text" name="precio_unitario[]" class="form-control input-md precio_unitario" autocomplete=off placeholder="Precio Unitario" id="precio_unitario" value="{{ $detalles[$key]->precio_unitario }}" required/>
                        </div>
                    </td>
                    <td class="col-sm-2">
                        <input type="text" name="sub_total[]" class="form-control input-md sub_total" placeholder="Sub Total" id="sub_total" readonly="">
                    </td>
                    <td class="col-1" >
                        <p  class="btn btn-danger remove_field_old">Eliminar</p>
                    </td>
                </tr>
                @endforeach
                @endif
                
                <?php
                if($isProducto)
                {
                $row = '<td class="col-sm-4 input-group"  >
                    <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="" placeholder="Nombre Produto" required="">
                    
                    <div class="seleccionID" id="seleccionID" style="display:noe;">
                        <input type="text" class="form-control input-sm  seleccion" name="producto_id[]" id="producto_id" value="" placeholder="p id" readonly style="height:20px;width:40px;display:noe;">
                    </div>
                    <div id="" style="display: noe;" >
                        <input type="text" id="eliminar" value="no" name="eliminar[]" style="height: 20px; width: 30px;">
                        <input type="text" name="detalle_id[]" value="" style="height: 20px; width: 30px;">
                    </div>
                </td>';
                }
                else
                {
                $row = '<td class="col-sm-4 input-group"  >
                    <input type="text" class="form-control input-sm descripcion" name="descripcion[]" id="descripcion" value="" placeholder="Descripcion" required = "">
                    <div id="" style="display: noe;" >
                        <input type="text" id="eliminar" value="no" name="eliminar[]" style="height: 20px; width: 30px;">
                        <input type="text" name="detalle_id[]" value="" style="height: 20px; width: 30px;">
                    </div>
                </td>';
                }
                
                $row = $row.'<td class="col-sm-2" >
                    <input type="text" name="cantidad[]" class="form-control input-md cantidad" id="cantidad" placeholder="Cantidad" autocomplete=off required/>
                </td>
                <td class="col-sm-1" style="display:noe">
                    <select class="form-control iva" name="iva[]" id="iva" >
                        <option value="0" >0%</option>
                        <option value="21" >5%</option>
                        <option value="11" selected>10%</option>
                    </select>
                </td>
                <td class="col-sm-2" >
                    <div class="form-group">
                        <input type="text" name="precio_unitario[]" class="form-control input-md precio_unitario" autocomplete=off placeholder="Precio Unitario" id="precio_unitario" required/>
                    </div>
                </td>
                <td class="col-sm-2" >
                    <input type="text" name="sub_total[]" class="form-control input-md sub_total" placeholder="Sub Total" id="sub_total" readonly="">
                </td>'
                ;
                $row_delete=    '<td class="col-1" >
                    <p  class="btn btn-danger remove_field">Eliminar</p>
                </td>'
                ?>
                
            </tr>
        </tbody>
        
        <tfoot>
        <tr>
            <th colspan="3">
                <td colspan="0">
                    <strong>Monto total</strong>
                </td>
                
                <td colspan="1">
                    <input type="text" name="monto_total_iva" autocomplete=off class="form-control input-md monto_total_iva" id="monto_total_iva" readonly/>
                </td>
            </th>
            
        </tr>
        </tfoot>
    </table>
</div>
@include('compras::admin.compras.partials.script')