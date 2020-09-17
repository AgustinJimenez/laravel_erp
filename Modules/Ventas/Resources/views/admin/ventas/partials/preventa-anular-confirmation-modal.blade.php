<div class="modal fade modal-danger" id="pago-anular-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title text-center" id="delete-confirmation-title">CONFIRMACI&Oacute;N</h4>
            </div>

            <div class="modal-body text-center">
                <div id="mensaje-eliminar">DESEA ANULAR LA PREVENTA? SE GENERARA UN CONTRA-ASIENTO.</div>
            </div>

            
            <div class="modal-footer">
            <a class="btn btn-outline btn-flat" href="{{ route('admin.ventas.venta.anular_asientos_preventa', $venta->id) }}"> <b> ANULAR </b> </a>
            <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>

    </div>
</div>
