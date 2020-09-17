<div class="form-group has-feedback">
    <div class="col-md-3 {!! $errors->first('cliente_id',  'has-error') !!}">
        <label for="fecha_inicio" class="control-label" >Cliente:   </label>
        <div class="input-group">
            <input type="text" class="form-control  input-sm" name="cliente" id="cliente" value="{{ old('cliente') }}"  required=''>
            <div class="help-block with-errors"></div>                                           
            <span class="input-group-btn">
                <button class="btn btn-primary btn-flat input-sm" type="button" data-toggle="modal" data-target="#clienteModal"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
            </span>
        </div>
        <!--
        <div style="display: noe;">
            <input type="" class="input-sm" value="{{ old('cliente_id') }}" name="cliente_id" placeholder="cliente_id" id="cliente_id" placeholder="cliente id" readonly="" style=" width: 40px; height: 20px;">
        </div>
        -->
        {!! $errors->first('cliente_id', '<p style="font-size: 10px; color:red;">:message</p>') !!}
    </div>
</div>
<!--*************************************************Cliente Modal *****************************************************************************************-->

    <div class="modal fade" id="clienteModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" >

                <div class="alert alert-success" id="modal-header-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Cliente creado satisfactoriamente.
                </div>
                <div class="alert alert-error" id="modal-header-error" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Error al crear cliente.
                </div>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong>Crear Cliente</strong></h4>
            </div>
            <div class="modal-body">
            {!! Form::open(['route' => ['admin.clientes.cliente.store'], 'method' => 'post', 'id' => 'cliente_form']) !!}
                {!! Form::normalInput('razon_social', 'Nombre o Razon Social', $errors) !!}
                {!! Form::normalInput('cedula', 'Cedula', $errors) !!}
                {!! Form::normalInput('ruc', 'RUC', $errors) !!}
                {!! Form::normalInput('direccion', 'Dirección', $errors) !!}
                {!! Form::normalInput('email', 'Email', $errors) !!}
                {!! Form::normalInput('telefono', 'Teléfono', $errors) !!}
                {!! Form::normalInput('celular', 'Celular', $errors) !!}
                {!! Form::normalCheckbox('activo', 'Activo', $errors, (object)['activo' => 1]) !!}
                @if($isVenta)
                    <input type="hidden" class="" name="isVentaCliente" id="" value="1" readonly="">
                @else
                    <input type="hidden" class="" name="isPreVentaCliente" id="" value="1" readonly="">
                @endif
                <div class="box-footer">
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-flat cliente_submit_button">Crear</button>
                        <button type="button" class="btn btn-danger pull-right btn-flat"  data-dismiss="modal"zzz><i class="fa fa-times"></i>Cancel</button>
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

	$("#cliente_form").submit(function(event)
    {
        event.preventDefault();

        $.ajax(
        {
            url: '{!! route('admin.clientes.cliente.store') !!}',
            type: 'POST',
            data: $(this).serialize(), 
            dataType: 'json',
            success: function( result )
            {

                $("input[name=cliente]").val( result['razon_social'] );

                $("input[name=cliente_id]").val(result['id']);


                if(!result['success'])
                {

                    $("#modal-header-error").show().delay(5000).queue(function(n) 
                    {
                      $(this).hide(); n();
                    });
                }
                else
                {   
                    $("#clienteModal").modal('hide');

                    $("#modal-header-success").show().delay(5000).queue(function(n) 
                    {

                        $(this).hide(); n();

                        $("#cliente_form").trigger("reset");

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

        var message_cedula = message['cedula'];

        var message_ruc = message['ruc'];

        var message_email = message['email']

        var message_telefono = message['telefono']

        var message_celular = message['celular']

        $("#modal-header-error").show().delay(5000).queue(function(n) 
        {
          $(this).hide(); n();
        });

        if(message_razon_social)
        {
            console.log( message_razon_social );

            input_error_messages( $("#razon_social"), message_razon_social );
            
        }
        else if(message_cedula)
        {
            console.log( message_cedula );

            
            input_error_messages( $("#cedula"), message_cedula );

        }
        else if(message_ruc)
        {
            console.log( message_ruc );

            input_error_messages( $("#ruc"), message_ruc );

        }
        else if(message_email)
        {
            console.log( message_email );

            input_error_messages( $("#email"), message_email );

        }
        else if(message_telefono)
        {
            console.log( message_telefono );

            input_error_messages( $("#telefono"), message_telefono );

        }
        else if(message_celular)
        {
            console.log( message_celular );

            input_error_messages( $("#celular"), message_celular );

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

    $( "#cliente" ).autocomplete(
    {
        source: '{!! route('admin.clientes.cliente.search_cliente') !!}',

        minLength: 1,

        select: function(event, ui) 
        {
            $( "#cliente_id" ).val( ui.item.id );
        }

    });

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck(
    {
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

});
</script>