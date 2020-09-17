<?php namespace Modules\Contabilidad\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Asiento extends Model
{
    protected $table = 'contabilidad__asientos';
    protected $fillable = 
    [
    	'fecha',
        'observacion',
        'total_debe',
        'total_haber',
        'operacion',
        'usuario_create_id',
        'usuario_edit_id',
        'entidad_id',
        'entidad_type'
    ];



    public function usuario_create()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_create_id');
    }

    public function usuario_edit()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_edit_id');
    }

    public function format($attribute, $type = 'number', $date_format = 'd/m/Y')
    {
        if($type == 'number')
            return number_format($this[$attribute], 0, '', '.');

        if($type == 'date')
            return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);
        else
            return 'format_number($attribute, $type=["number","date"]) ';
    }

    public function getObservacionReducidaAttribute()
    {
        $observacion = $this->observacion;
        $max_length = 120;
        return ( strlen( $observacion ) > $max_length) ? str_limit($observacion, $max_length) . '...' : (string)$observacion ;
    }

    public function with_edit_link($attribute)
    {
        $edit_route = route('admin.contabilidad.asiento.edit', [$this->id]);
        
        $attribute_with_edit_link = '<a href="' . $edit_route . '">' . $this[$attribute] . '</a>';

        return $attribute_with_edit_link;
    }

    public function getEditButtonAttribute()
    {
        $edit_route = route('admin.contabilidad.asiento.edit', $this->id);
        return '<a href="' . $edit_route .'" class="btn btn-primary btn-flat"><b>Asiento ' . $this->operacion . '</b></a>';
    }

    public function detalles()
    {
        return $this->hasMany('Modules\Contabilidad\Entities\AsientoDetalle', 'asiento_id');
    }
    
    public function usuario_apellido_nombre($create_or_edit = 'create')
    {

        if($create_or_edit != 'create' && $create_or_edit != 'edit')
            return 'use "create" or "edit" on function';

        $usuario = $this['usuario_'.$create_or_edit];

        if(!$usuario)
            return null;

        $apellido_nombre = $usuario->last_name.' '.$usuario->first_name;

        return $apellido_nombre;
    }

    public function entidad()
    {
        return $this->morphTo();
    }

    public function getAnularButtonAttribute()
    {
        $action = 'anular';

        $anular_route = route('admin.contabilidad.asiento.anular', [$this->id]);

        $message = '¿Estás seguro que quieres anular este pago? se generara un contra-asiento.';

        $button_html = "<button class='btn btn-danger btn btn-primary anular-asiento-button' data-target='#modal-" . $action . "-confirmation-pago-".$this->id."'>
                            <strong>ANULAR</strong>
                        </button>";

        $button_html .= $this->modal_anular_confirmation($action, $message, $anular_route);

        return $button_html;
    }

    public function modal_anular_confirmation($action = 'anular', $message = '', $target = "#")
    {
        

        $modal_html = '<div class="modal fade modal-danger" id="modal-' . $action . '-confirmation-pago-'.$this->id.'" tabindex="-1" role="dialog" aria-labelledby="' . $action . '-confirmation-title" aria-hidden="true">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title" id="' . $action . '-confirmation-title">Confirmación</h4>
                                    </div>

                                    <div class="modal-body">
                                        ' . $message . ' 
                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Cancelar</button>
                                        <a class="btn btn-outline btn-flat" href="' . $target . '">

                                            
                                            Anular

                                        </a>
                                        
                                    </div>

                                </div>

                            </div>

                        </div>';


        return $modal_html;
    }

    public function generar_contraasiento( $usuario_id )
    {
        $asiento = new \Asiento();
        $asiento->fecha = date("Y-m-d");
        $asiento->operacion = "Anulacion de " . $this->operacion;
        $asiento->observacion = "Anulacion de " . $this->observacion;
        $asiento->usuario_create_id = $usuario_id;
        $asiento->entidad_id = $this->entidad_id;
        $asiento->entidad_type = $this->entidad_type;
        $asiento->save();
        
        foreach ($this->detalles as $key => $detalle) 
        {
            $asiento_detalle = new \AsientoDetalle();
            $asiento_detalle->asiento_id = $asiento->id;
            $asiento_detalle->cuenta_id = $detalle->cuenta_id;
            $asiento_detalle->debe = $detalle->haber;
            $asiento_detalle->haber = $detalle->debe;
            $asiento_detalle->save();
        }

    }
}
