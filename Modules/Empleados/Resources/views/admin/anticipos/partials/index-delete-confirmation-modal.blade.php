<div class="modal fade modal-danger" id="anticipo-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title text-center" id="delete-confirmation-title">CONFIRMACION</h4>
            </div>

            <div class="modal-body text-center">
                <div id="mensaje-eliminar">DESEA ANULAR EL ANTICIPO? SE GENERARA UN CONTRAASIENTO.</div>
                <div id="mensaje-no-eliminar">NO SE PUEDE ANULAR EL ANTICIPO POR QUE YA HA SIDO DESCONTADO.</div>
            </div>

            <div class="modal-footer">
                {!! Form::open(['route' => null, 'method' => 'delete', 'id' => 'delete-form']) !!}
                <button type="submit" class="btn btn-outline btn-flat" id="boton-confirmacion-eliminar">
                    ANULAR 
                </button>
                <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">CANCELAR</button>
                {!! Form::close() !!}
            </div>

        </div>

    </div>
</div>
