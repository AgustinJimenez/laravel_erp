<div class="modal fade modal-danger" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="delete-confirmation-title">Confirmación</h4>
            </div>

            <div class="modal-body">
                
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Atras</button>
                    <form method="POST" action="" accept-charset="UTF-8" class="pull-left" id="confirmation-modal-form">
                        <input name="_method" type="hidden" value="DELETE" autocomplete="off">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-outline btn-flat">
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                    </form>
            </div>

        </div>
    </div>
</div>