<?php namespace Modules\Ventas\Entities;


use Illuminate\Database\Eloquent\Model;
use DateTime;

class FacturaVenta extends Model
{


    protected $table = 'ventas__facturaventas';
    protected $fillable = 
    [
    	'venta_id',//
    	'nro_factura',//
    	'timbrado',//
    	'fecha',//
    	'anulado',//
    	'tipo_factura',//
    	'observacion',//
    	'usuario_sistema_id_create',//
        'usuario_sistema_id_edit'//

    ];

    protected $appends = ['fecha_formateada'];

    public function getFechaFormateadaAttribute()
    {
        $date = $this->attributes['fecha'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }

    public function venta()
    {
        return $this->belongsTo('Modules\Ventas\Entities\Venta','venta_id');
    }


   public function getTipoEntidadAttribute()
   {
        return 'factura_venta';
   }

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function asiento()
    {
        return $this->first();
    }

    public function getFacturaButtonAttribute()
    {
        $factura_route = route('admin.ventas.facturaventa.edit', $this->id);

        return ' <a href="'.$factura_route.'" class="btn btn-primary btn-flat"> Detalles de Factura </a> ';
    }

    public function getUsuarioApellidoNombreAttribute($create_or_edit = 'create')
    {
        return $this->venta->usuario_apellido_nombre($create_or_edit);
    }

    public function getAsientosButtonsAttribute()
    {
        $asientos = $this->venta->asientos_all;

        $links = '';

        foreach ($asientos as $key => $asiento) 
        {
            $asiento_edit_route = route('admin.contabilidad.asiento.edit', $asiento->id);

            $links = $links.'<a href="'.$asiento_edit_route.'" class="btn btn-primary btn-flat">'.$asiento->operacion.' </a><br><br>'; 
        }

        return $links;
        
    }
    
}
