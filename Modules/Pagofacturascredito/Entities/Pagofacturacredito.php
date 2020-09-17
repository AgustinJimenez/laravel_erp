<?php namespace Modules\Pagofacturascredito\Entities;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class Pagofacturacredito extends Model
{
    protected $table = 'ventas_pago_factura_credito';
    protected $fillable = 
    [
    	'venta_id',
    	'fecha',
    	'monto',
    	'caja_id',
    	'forma_pago'
    ];

    public function getFechaFormatAttribute()
	{
        return DateTime::createFromFormat('Y-m-d', $this['fecha'])->format('d/m/Y');
	}

	public function getMontoFormatAttribute()
	{
        return number_format($this->attributes['monto'], 0, '', '.');
	}

    public function venta()
    {
        return $this->belongsTo('Modules\Ventas\Entities\Venta', 'venta_id');
    }

    public function caja()
    {
        return $this->belongsTo('Modules\Caja\Entities\Caja', 'caja_id');
    }

    public function getDeleteButtonAttribute()
    {
        if(count($this->asientos)<1)
            return '';

        $button_html = "<button class='btn btn-danger btn-xs eliminar-pago-button' data-target='#modal-delete-confirmation-pago-".$this->id."'>
                            <strong>ELIMINAR</strong>
                        </button>";

        $button_html .= $this->modal_delete_confirmation;

        return $button_html;
    }

    public function getModalDeleteConfirmationAttribute()
    {
        $deleteRoute = route('admin.pagofacturascredito.pagofacturacredito.destroy', [$this->id]);

        $modal_html = '<div class="modal fade modal-danger" id="modal-delete-confirmation-pago-'.$this->id.'" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="delete-confirmation-title">Confirmación</h4>
                                    </div>

                                    <div class="modal-body">
                                        ¿Estás seguro que quieres eliminar este pago? se eliminara tambien su asiento. 
                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Cancelar</button>
                                        <a class="btn btn-outline btn-flat" href="'.$deleteRoute.'">

                                            <i class="fa fa-trash"></i> 
                                            Eliminar

                                        </a>
                                        
                                    </div>

                                </div>

                            </div>

                        </div>';


        return $modal_html;
    }

    public function getFormaPagoFormatAttribute()
    {
        if($this['forma_pago'] == 'efectivo')
            return 'Efectivo';
        else if($this['forma_pago'] == 'cheque')
            return 'Cheque';
        else if($this['forma_pago'] == 'tarjeta_credito')
            return 'Tarjeta de Credito';
        else
            return 'Tarjeta de Debito';

    }

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function getTipoEntidadAttribute()
    {
        if($this->venta->tipo == 'venta')
            return 'pago_venta';
        else
            return 'pago_preventa';
    }

    public function getAsientosLinksAttribute()
    {
        $asientos = $this->asientos;

        $links = '';

        foreach ($asientos as $key => $asiento) 
        {
            $asiento_edit_route = route('admin.contabilidad.asiento.edit', $asiento->id);

            $links = $links.'<a href="'.$asiento_edit_route.'" class=""> -'.$asiento->operacion.' </a><br>'; 
        }

        return $links;
    }


    public function getFacturaButtonAttribute()
    {
        $factura = $this->venta->factura;

        if($factura)
        {
            $factura_route = route('admin.ventas.facturaventa.edit', $factura->id);

            return ' <a href="'.$factura_route.'" class="btn btn-primary btn-flat"> VER FACTURA </a> ';
        }
        else 
        {
            $venta_edit_route = route('admin.ventas.venta.edit', $this->venta->id);
            
            return ' <a href="'.$venta_edit_route.'" class="btn btn-primary btn-flat"> VER DETALLES DE PREVENTA </a> ';
        }
    }

}


