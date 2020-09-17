<?php namespace Modules\Compras\Entities;
   
use Illuminate\Database\Eloquent\Model;
use DateTime, stdClass;

class CompraPago extends Model {

	protected $table = 'compras_pagos';
    protected $fillable = 
    [
    	'compra_id',
    	'caja_id',
    	'fecha',
    	'forma_pago',
    	'monto'
    ];

    public function format($attribute, $type, $date_format = 'd/m/Y')
    {
    	if($type == 'number')
    		return number_format($this[$attribute], 0, '', '.');

    	if($type == 'date')
    		return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);
    	
    	else
    		return ' format_number($attribute, $type=["number","date"]) ';
    }

    public function getFormaPagoFormatAttribute()
    {
        if($this['forma_pago'] == 'efectivo')
            return 'Efectivo';
        else if($this['forma_pago'] == 'cheque')
            return 'Cheque';
        else if($this['forma_pago'] == 'tarjeta_credito')
            return 'Tarjeta de Credito';
        else if($this['forma_pago'] == 'tarjeta_debito')
            return 'Tarjeta de Debito';
        else
        	return 'invalid forma_pago';

    }

    public function compra()
    {
        return $this->belongsTo('Modules\Compras\Entities\Compra', 'compra_id');
    }


    public function getAsientoEditRouteAttribute()
    {
        if(!$this->asiento)
            return '';
        else
            return route('admin.contabilidad.asiento.edit', $this->asiento->id);
    }

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function getTipoEntidadAttribute()
    {
        return 'pago_compra';
    }

    public function getFacturaButtonAttribute()
    {
        $factura_route = route('admin.compras.compra.factura', $this->compra->id);

        return ' <a href="'.$factura_route.'" class="btn btn-primary btn-flat"> VER FACTURA </a> ';
        
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
        $deleteRoute = route('admin.compras.comprapago.destroypago', [$this->id]);

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

}