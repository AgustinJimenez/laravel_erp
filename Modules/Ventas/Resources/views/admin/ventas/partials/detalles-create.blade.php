<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>

<div class="overflow-x:auto;" id="div_tabla">
  <br><br><br><br>
    <table id="tabla_detalle_venta" class="table table-bordered table-striped table-highlight table-fixed tabla_detalle_venta">
        <thead>
            <tr>
            @if($isVenta || $isPreventa)
                <th class="col-sm-1 text-center" >Tipo</th>
                <th class="col-sm-2 text-center">Seleccion</th>
            @else
                <th class="col-sm-2 text-center">Descripcion</th>
            @endif
                <th class="col-sm-1 text-center" style="width: 1%;">Cantidad</th>
                <th class="col-sm-1 text-center" style="width: 5.5%;">IVA</th>
                <th class="col-sm-1 text-center" style="width: 4%;">Precio Unitario</th>
                {{-- <th class="col-sm-1 text-center" style="width: 4%;">Descuento</th> --}}
                <th class="col-sm-1 text-center" style="width: 5%;">Precio Total</th>
                <th class="col-sm-1 text-center" style="width: 2%;">Accion</th>
            </tr>
        </thead>

        <tbody id="venta_detalle" class="">
@if($isVenta || $isPreventa)
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
    $columnTipo = '<td class="col-sm-1" >
                        <select class="form-control tipo" name="tipo[]" id="tipo" >
                            <option value="producto" checked>Producto</option>
                            <option value="cristal" >Cristal</option>
                            <option value="servicio" >Servicio</option>
                        </select>
                    </td>';
    if (!count($errors))
    {
        echo $columnTipo;
                    
    }?>
@else
    <?php /*----------------------------------------------------------------------------------------------------------------------------*/
    $columnTipo = '<td class="col-sm-1" style="display:none" >
                        <select class="form-control tipo" name="tipo[]" id="tipo" >
                            <option value="otros" checked>Otros</option>
                        </select>
                    </td>';
    if (!count($errors))
    {
        echo $columnTipo;
                    
    }?>
@endif
@if($isVenta || $isPreventa)
<?php  /*----------------------------------------------------------------------------------------------------------------------------*/
$columnSeleccion = '<td class="col-md-2 input-group">
                        
                        <div id="divProductos" class="form-group" >

                            <input type="text" class="form-control input-sm producto" name="nombre_producto[]" id="nombre_producto" value="" placeholder="Nombre Produto" required="">
                        </div>

                        <div id="divServicios" style="display:none;" class="form-group">

                            <input type="text" class="form-control input-sm servicio" name="nombre_servicio[]" id="nombre_servicio" value="" placeholder="Nombre Servicio" >
                        </div>

                        <div id="divCristales" style="display:none;" class="form-group">

                        <div class="row">
                            <div class="col-md-1 width33"> 
                                <select id="categoria_cristal" name="categoria_cristal_id[]" class="form-control input-md col-sm-1  select_categoria_cristal0">
                                    <option selected value="" >Categoria</option>';?>
                    @foreach($categorias as $categoria)<?php
                    $columnSeleccion =  $columnSeleccion.'<option value="'.$categoria->id.'">'.$categoria->nombre.'</option>';?>
                    @endforeach<?php
                    $columnSeleccion = $columnSeleccion.'</select>
                                                </div>
                        
                            <div class="col-md-1 width33"> 
                                <select id="cristal" name="cristal_subcategoria_id[]" class="form-control input-md col-sm-1  select_cristal0">
                                    <option selected value="" >Cristal</option>';?>
                                @foreach($cristales as $cristal)<?php 
$columnSeleccion = $columnSeleccion.'<option value="'.$cristal->id.'" class="'.$cristal->categoria->id.'">'.$cristal->nombre.'</option>';?>
                                @endforeach<?php  
$columnSeleccion =$columnSeleccion.'</select>
                            </div>
                        
                            <div class="col-md-1 width33"> 
                                <select id="tipo_cristal" name="cristal[]" class="form-control input-md col-sm-1 select_tipo_cristal_ajax  select_tipo_cristal0">
                                    <option selected value="" >Tipo o Graduacion</option>';?>
                                @foreach($tipos as $tipo)<?php    
$columnSeleccion =$columnSeleccion.'<option value="'.$tipo->id.'" class="'.$tipo->cristal->id.'">'.$tipo->nombre.'</option>';?>
                                @endforeach<?php  
$columnSeleccion = $columnSeleccion.'</select>

                            </div>
                        </div>

         <!--***--> </div>

                    <div class="seleccionID" id="seleccionID" style="display:none" margin-top: 0%; float:left;">

                        <input type="text" class="form-control input-sm  seleccion" name="producto_id[]" id="producto_id" value="" placeholder="p id" readonly style="height:20px;width:40px;'.$debug.'">

                        <input type="text" class="form-control input-sm  seleccion" name="servicio_id[]" id="servicio_id" value="" placeholder="s id" readonly style="height:20px;width:40px;'.$debug.'">

                        <input type="text" class="form-control input-sm  seleccion" name="cristal_id[]" id="cristal_id" value="" placeholder="c id" readonly style="height:20px;width:40px;'.$debug.'">
                    </div>
                </td>';?>                    
<?php if (!count($errors))echo $columnSeleccion;?>


@else

    <?php  /*----------------------------------------------------------------------------------------------------------------------------*/
$columnSeleccion = '<td class="col-md-2 input-group">
                        
                        <div id="divProductos" class="form-group" >

                            <input type="text" class="form-control input-sm producto" name="nombre_producto[]" id="nombre_producto" value="" placeholder="" required="">
                        </div>

                        <div id="divServicios" style="display:none;" class="form-group">

                            <input type="text" class="form-control input-sm servicio" name="nombre_servicio[]" id="nombre_servicio" value="" placeholder="" >
                        </div>

                        <div id="divCristales" style="display:none;" class="form-group">

                        <div class="row">
                            <div class="col-md-1 width33"> 
                                <select id="categoria_cristal" name="categoria_cristal_id[]" class="form-control input-md col-sm-1  select_categoria_cristal0">
                                    <option selected value="" >Categoria</option>';?>
                    @foreach($categorias as $categoria)<?php
                    $columnSeleccion =  $columnSeleccion.'<option value="'.$categoria->id.'">'.$categoria->nombre.'</option>';?>
                    @endforeach<?php
                    $columnSeleccion = $columnSeleccion.'</select>
                                                </div>
                        
                            <div class="col-md-1 width33"> 
                                <select id="cristal" name="cristal_subcategoria_id[]" class="form-control input-md col-sm-1  select_cristal0">
                                    <option selected value="" >Cristal</option>';?>
                                @foreach($cristales as $cristal)<?php 
$columnSeleccion = $columnSeleccion.'<option value="'.$cristal->id.'" class="'.$cristal->categoria->id.'">'.$cristal->nombre.'</option>';?>
                                @endforeach<?php  
$columnSeleccion =$columnSeleccion.'</select>
                            </div>
                        
                            <div class="col-md-1 width33"> 
                                <select id="tipo_cristal" name="cristal[]" class="form-control input-md col-sm-1 select_tipo_cristal_ajax  select_tipo_cristal0">
                                    <option selected value="" >Tipo o Graduacion</option>';?>
                                @foreach($tipos as $tipo)<?php    
$columnSeleccion =$columnSeleccion.'<option value="'.$tipo->id.'" class="'.$tipo->cristal->id.'">'.$tipo->nombre.'</option>';?>
                                @endforeach<?php  
$columnSeleccion = $columnSeleccion.'</select>

                            </div>
                        </div>

         <!--***--> </div>

                    <div class="seleccionID" id="seleccionID" style="display:none" margin-top: 0%; float:left;">

                        <input type="text" class="form-control input-sm  seleccion" name="producto_id[]" id="producto_id" value="" placeholder="" readonly style="height:20px;width:40px;'.$debug.'">

                        <input type="text" class="form-control input-sm  seleccion" name="servicio_id[]" id="servicio_id" value="" placeholder="" readonly style="height:20px;width:40px;'.$debug.'">

                        <input type="text" class="form-control input-sm  seleccion" name="cristal_id[]" id="cristal_id" value="" placeholder=" readonly style="height:20px;width:40px;'.$debug.'">
                    </div>
                </td>';?>                    
<?php if (!count($errors))echo $columnSeleccion;?>

@endif
                                                
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
     $columnDetalleCristal='';if (!count($errors))echo $columnDetalleCristal;?>
                                                
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
    $columnCantidad = '<td class="col-sm-1" style="width: 1%;" >
                            <input type="text" name="cantidad[]" class="form-control input-md cantidad" id="cantidad" placeholder="Cantidad" autocomplete=off required/>
                        </td>';
if (!count($errors))echo $columnCantidad;?>
                                                
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
    $columnIva = '<td class="col-sm-1" style="width: 5.5%;">
                            <select class="form-control iva" name="iva[]" id="iva" >
                                <option value="0" >0%</option>
                                <option value="21" >5%</option>
                                <option value="11" selected>10%</option>
                            </select>
                        </td>';
    if (!count($errors))echo $columnIva;?>
                                                
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
     $columnPrecioUnitario = '<td class="col-sm-1" style="width: 4%;">
                                <div class="form-group">

                                    <input type="text" name="precio_unitario[]" class="form-control input-md precio_unitario" autocomplete=off placeholder="Precio Unitario" id="precio_unitario" required/>
                                     <input type="hidden" name="precio" class="form-control input-md precio_hide placeholder="Precio" id="precio_hide" required/>
                                </div>
                            </td>';
    if (!count($errors))echo $columnPrecioUnitario;?>
 
 
{{--                 $columnDescuento = 
                '<td class="col-sm-1" style="width: 4%;">
                    <div class="form-group">
                        <input type="text" name="precio_descuento[]" class="form-control input-md precio_descuento" autocomplete=off placeholder="Descuento" id="precio_descuento" required/>
                        <input type="hidden" name="descuento" class="form-control input-md descuento_hide autocomplete=off placeholder="Descuento hide" id="descuento" required/>
                    </div>
                </td>';

                if (!count($errors))echo $columnDescuento;?> --}}
 


<?php /*----------------------------------------------------------------------------------------------------------------------------*/
 $columnPrecioTotal = '';if (!count($errors))echo $columnPrecioTotal;?>
                                                
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
 $columnSubTotal = '<td class="col-sm-1" style="width: 5%;">
                            <input type="text" name="precio_total[]" class="form-control input-md sub_total" placeholder="Precio Total" id="sub_total" readonly="">
                        </td>';
    if (!count($errors))echo $columnSubTotal;?>

                        
<?php /*----------------------------------------------------------------------------------------------------------------------------*/
$columnAccion = '<td class="col-sm-1" style="width: 2%;">
                            <i class="glyphicon glyphicon-trash btn btn-danger remove_field"></i>
                        </td>';?>
                                 
        </tbody>
        @if($isVenta || $isPreventa)
        <tfoot>
            <tr>
                <th colspan="4">
                    <td colspan="0">
                        <strong>Descuento</strong>
                    </td>
                    <td colspan="1">

                        <input type="text" name="descuento_total" value="{{ old('descuento_total') }}"  autocomplete=off class="form-control input-md descuento_total" id="descuento_total" >
                    </td>
                </th>
            </tr>

            <tr>
                <th colspan="4">
                    <td colspan="0">
                        <strong>Monto total</strong>
                    </td>
                    <td colspan="1">
                        <input type="text" name="monto_total_tabla" value="{{ old('monto_total_tabla') }}"  autocomplete=off class="form-control input-md monto_total_iva" id="monto_total_iva" readonly/>
                    </td>
                </th>
            </tr>
        </tfoot>
        @else
        <tfoot>
            <tr>
                
                <td  class="text-right" colspan="4">
                    <strong>Descuento</strong>
                </td>
                <td colspan="1">
                    <input type="text" name="descuento_total" value=""  autocomplete=off class="form-control input-md descuento_total" id="descuento_total" >
                </td>
                
            </tr>

            <tr>
                
                <td class="text-right" colspan="4">
                    <strong>Monto total</strong>
                </td>
                <td colspan="1">
                    <input type="text" name="monto_total_tabla" value="{{ old('monto_total_tabla') }}"  autocomplete=off class="form-control input-md monto_total_iva" id="monto_total_iva" readonly/>
                </td>
                
            </tr>

        
            
        </tfoot>
        @endif
    </table>

    <div class="form-group" style="margin-left:1%;" >
        <a href="#" id="agregar" class="btn btn-primary btn-flat">Agregar Detalle</a>
    </div>
</div>
@if($isOtros)
    @include('ventas::admin.ventas.venta_script_otrasVentas')
@else
    @include('ventas::admin.ventas.venta_script')
@endif