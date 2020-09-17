<?php                                                                 $debug_ap = false
;
  $debug_ap = $debug_ap?"":"style='display:none;'";
?>
<style type="text/css">
  .ui-autocomplete 
  {
    position: absolute;
    z-index: 2150000000 !important;
    cursor: default;
    border: 2px solid #ccc;
    padding: 5px 0;
    border-radius: 2px;
  }
</style>
<div class="modal fade" tabindex="-1" role="dialog" id="agregar-items-preventa-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">AGREGAR ITEM</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['route' => ['admin.ventas.venta.preventa_agregar_items', $venta->id], 'method' => 'put', 'id' => 'formulario-agregar-item-preventa', 'role'=>'form']) !!} 
          <fieldset id="agregar-item-preventa-fieldset">
            <div class="form-group hidden_inputs row" {!! $debug_ap !!}> 
              {!! Form::text('detalle[producto_id]', '', array('class' => '', 'placeholder' => 'producto id', "id" => "detalle_producto_id")) !!}
              {!! Form::text('detalle[servicio_id]', '', array('class' => '', 'placeholder' => 'servicio id',  "id" => "detalle_servicio_id")) !!}
            </div>

            <div class="form-group tipo"> 
              {!! Form::label('for_tipo', 'Tipo', array('class' => 'form')) !!}
              {!! Form::select('detalle[tipo]', ["producto" => "Producto", "servicio" => "Servicio", "cristal" => "Cristal"], null, ['class' => 'form-control', "id" => "detalle_tipo"]) !!}
            </div>

            <div class="form-group descripcion"> 
              {!! Form::label('for_tipo', 'Descripcion', array('class' => 'form')) !!}
              {!! Form::text('detalle[descripcion]', '', array('class' => 'form-control agregar-item-preventa-descripcion', "id" => "detalle_descripcion_producto")) !!}
              <p class="text-success" id="item_selected_message"></p>
            </div>

            <div class="form-group seleccion-cristal row"> 
              <div class="col-md-4">
                {!! Form::label('for_categoria_cristal', 'Categoria', array('class' => 'form')) !!}
                {!! Form::select('detalle[categoria_cristal]', $categorias->lists('nombre', 'id')->prepend("Categoria", ""), null, ['class' => 'form-control', "id" => "detalle_categoria_cristal"]) !!}
              </div>
              <div class="col-md-4">
                {!! Form::label('for_cristal', 'Cristal', array('class' => 'form')) !!}
                <select class="form-control" id="detalle_cristal" name="detalle[cristal]">
                  <option value="">Cristal</option>
                  @foreach ($cristales as $cristal)
                    <option value="{{ $cristal->id }}" class="{{ $cristal->categoria->id }}">{{ $cristal->nombre }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                {!! Form::label('for_tipo_cristal', 'Tipo o Graduacion', array('class' => 'form')) !!}
                <select class="form-control" id="detalle_cristal_id" name="detalle[cristal_id]">
                   <option value="">Tipo o Graduacion</option>
                  @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" class="{{ $tipo->cristal->id }}">{{ $tipo->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group cantidad col-md-4"> 
                {!! Form::label('for_cantidad', 'Cantidad', array('class' => 'form')) !!}
                {!! Form::text('detalle[cantidad]', '', array('class' => 'form-control', "id" => "detalle_cantidad", "required" => "required")) !!}
              </div>

              <div class="form-group iva col-md-4"> 
                {!! Form::label('for_iva', 'IVA', array('class' => 'form')) !!}
                {!! Form::select('detalle[iva]', [11 => "10%", 21 => "5%", 0 => "0%"], null, ['class' => 'form-control', "id" => "detalle_iva"]) !!}
              </div>

              <div class="form-group precio_unitario col-md-4"> 
                {!! Form::label('for_precio_unitario', 'Precio Unitario', array('class' => 'form')) !!}
                {!! Form::text('detalle[precio_unitario]', '', array('class' => 'form-control', "id" => "detalle_precio_unitario", "required" => "required")) !!}
              </div>
            </div>
            <div class="form-group precio_total"> 
              {!! Form::label('for_precio_total', 'Precio Total', array('class' => 'form')) !!}
              {!! Form::text('detalle[precio_total]', '', array('class' => 'form-control', "id" => "detalle_precio_total", 'tabIndex' => "-1", 'readonly' => 'readonly')) !!}
            </div>
          
          </fieldset>

          
        {!! Form::close() !!}
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-success" id="button_agregar_item_actualizar"><B>ACTUALIZAR</B></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><B>CANCELAR</B></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@include("ventas::admin.ventas.partials.aviso-modal")
