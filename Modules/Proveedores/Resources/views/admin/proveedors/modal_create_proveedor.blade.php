<div class="form-group has-feedback">
    <div class="{!! $errors->first('proveedor_id',  'has-error') !!}">
        <label for="fecha_inicio" class="control-label" >Proveedor:   </label>
        <div class="input-group">
            <input type="text" class="form-control  input-sm" name="proveedor" id="proveedor" value="{{ old('proveedor') }}"  required=''>
            <div class="help-block with-errors"></div>                                           
            <span class="input-group-btn">
                <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#proveedorModal"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
            </span>
        </div>
        
        {!! $errors->first('proveedor_id', '<p style="font-size: 10px; color:red;">:message</p>') !!}
    </div>
</div>
<!--*************************************************Proveedor Modal *****************************************************************************************-->

    <div class="modal fade" id="proveedorModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" >

                <div class="alert alert-success" id="modal-header-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Proveedor creado satisfactoriamente.
                </div>
                <div class="alert alert-error" id="modal-header-error" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Error al crear proveedor.
                </div>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong>Crear Proveedor</strong></h4>
            </div>
            <div class="modal-body">
            {!! Form::open(['route' => ['admin.proveedores.proveedor.store'], 'method' => 'post', 'id' => 'proveedor_form']) !!}
                {!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors) !!}
                {!! Form::normalInput('ruc', 'RUC', $errors) !!}
                {!! Form::normalInput('categoria', 'Categoria', $errors) !!}
                {!! Form::normalInput('direccion', 'Dirección', $errors) !!}
                {!! Form::normalInput('email', 'Email', $errors) !!}
                {!! Form::normalInput('telefono', 'Teléfono', $errors) !!}
                {!! Form::normalInput('celular', 'Celular', $errors) !!}
                {!! Form::normalInput('fax', 'Fax', $errors) !!}
                {!! Form::normalInput('contacto', 'Contacto', $errors) !!}
                @if($isCompra)
                    <input type="" name="isCompra" value="1" style="display: none;">
                    <input type="" name="isProducto" value="{{ $isProducto }}" style="display: none;">
                    <input type="" name="isServicio" value="{{ $isServicio }}" style="display: none;">
                    <input type="" name="isOtro" value="{{ $isOtro }}" style="display: none;">
                    <input type="" name="isCristal" value="{{ $isCristal }}" style="display: none;">
                @endif
                <div class="box-footer">
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-flat proveedor_submit_button">Crear</button>
                        <button type="button" class="btn btn-danger pull-right btn-flat"  data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                    </div>
                </div>
                 
            {!! Form::close() !!}
            </div>

          </div>
        </div>
    </div>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
$(document).ready(function()
{
	$("#proveedor_form").submit(function(event)
    {
        event.preventDefault();

        $.ajax(
        {
            url: '{!! route('admin.proveedores.proveedor.store') !!}',
            type: 'POST',
            data: $(this).serialize(), 
            dataType: 'json',
            success: function( result )
            {
                $("input[name=proveedor]").val( result['razon_social'] );

                $("input[name=proveedor_id]").val(result['id']);

                $("input[name=ruc_proveedor]").val( result['ruc'] );

                if(!result['success'])
                {
                    $("#modal-header-error").show().delay(5000).queue(function(n) 
                    {
                      $(this).hide(); n();
                    });
                }

                else
                {
                    $("#proveedorModal").modal('hide');

                    $("#modal-header-success").show().delay(5000).queue(function(n) 
                    {

                        $(this).hide(); n();

                        $("#proveedor_form").trigger("reset");

                    });
                }
            },
            error: function( result )
            {
                is_error( result );
            }
        });
          
    });

    function is_error( result )
    {
        var message = $.parseJSON('[' + result.responseText + ']')[0];

        var message_razon_social = message['razon_social'];

        var message_ruc = message['ruc'];

        var message_categoria = message['categoria'];

        var message_direccion = message['direccion'];

        var message_email = message['email'];

        var message_telefono = message['telefono'];

        var message_celular = message['celular'];

        var message_fax = message['fax'];

        var message_contacto = message['contacto'];

        $("#modal-header-error").show().delay(5000).queue(function(n) 
        {
          $(this).hide(); n();
        });

        if(message_razon_social)
        {
            input_error_messages( $("#razon_social"), message_razon_social );
            
        }
        else if(message_ruc)
        {
            input_error_messages( $("#ruc"), message_ruc );

        }
        else if(message_categoria)
        {
            input_error_messages( $("#ruc"), message_categoria );

        }
        else if(message_email)
        {
            input_error_messages( $("#email"), message_email );

        }
        else if(message_telefono)
        {
            input_error_messages( $("#telefono"), message_telefono );

        }
        else if(message_celular)
        {
            input_error_messages( $("#celular"), message_celular );

        }
        else if(message_contacto)
        {
            input_error_messages( $("#contacto"), message_contacto );

        }
        else if(message_fax)
        {
            input_error_messages( $("#fax"), message_fax );
        }
    }

    function input_error_messages(input, message)
    {
        input.parent().addClass('has-error').append('<span class="help-block" id="error-message">'+message+'</span>').delay(5000).queue(function(n) 
        {
          $(this).removeClass('has-error').find('span[id=error-message]').remove(); 
          n();

          

        });
    }

    $( "#proveedor" ).autocomplete(
    {
        source: '{!! route('admin.proveedores.proveedor.search_proveedor') !!}',

        minLength: 1,

        select: function(event, ui) 
        {
            $( "#proveedor_id" ).val( ui.item.id );

            $( "#ruc_proveedor" ).val( ui.item.ruc );
            
            $( "input[name=razon_social]" ).val(ui.item.value);
        }   

    });

});
</script>