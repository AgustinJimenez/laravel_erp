<?php namespace Modules\Ventas\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Ventas\Entities\Venta;
use DateTime;
use stdClass;
use DB;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Core\Contracts\Authentication;

class Venta extends Model
{

    protected $table = 'ventas__ventas';
    protected $fillable = 
    [
    	'nro_seguimiento',
        'tipo',
    	'fecha_venta',
        'caja_id',
        'descuento_total',
    	'monto_total',
    	'monto_total_letras',
        'grabado_excenta',
        'grabado_5',
        'grabado_10',
    	'total_iva_5',
    	'total_iva_10',
    	'total_iva',
    	'entrega',
    	'pago_final',
    	'total_pagado',
    	'descuento_porcentaje',
    	'descuento_monto',
    	'observacion_venta',
    	'estado',
    	'cliente_id',
    	'usuario_sistema_id_create',
        'usuario_sistema_id_edit',
        'ojo_izq',
        'ojo_der',
        'distancia_interpupilar',
        'ojo_izq_cercano',
        'ojo_der_cercano',
        'fecha_entrega'

    ];

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function getDescripcionAttribute()
    {
        if( count($this->detalles) >0 )
            return $this->detalles->first()->descripcion;
        else
            return '';
    }

    public function getMontoTotalFormateadoAttribute()
    {
        return number_format($this->attributes['monto_total'], 0, '', '.');
    }

    public function getTotalPagadoFormateadoAttribute()
    {
        return number_format($this->attributes['total_pagado'], 0, '', '.');
    }

    public function getTotalPagadoPagosAttribute()
    {
        $pagos = $this->pagos;

        $total_monto = 0;

        foreach ($pagos as $key => $pago) 
            $total_monto += $pago->monto;

        return $total_monto;
    }

    public function cliente()
    {
        return $this->belongsTo('Modules\Clientes\Entities\Cliente','cliente_id');
    }

    public function factura()
    {
        return $this->hasOne('Modules\Ventas\Entities\FacturaVenta', 'venta_id');
    }

    public function detalles()
    {
        return $this->hasMany('Modules\Ventas\Entities\DetalleVenta', 'venta_id');
    }

    public function pagos()
    {
        return $this->hasMany('Modules\Pagofacturascredito\Entities\Pagofacturacredito', 'venta_id', 'id');
    }

    public function getAsientosAllAttribute()
    {
        $asientos_venta = $asientos_pagos = $asientos_factura = [];

        foreach ($this->asientos as $key => $asiento) 
            $asientos_venta[] = $asiento;

        foreach ($this->pagos as $key => $pago) 
            if(count($pago->asientos)) 
                foreach ($pago->asientos as $key2 => $asiento) 
                    $asientos_pagos[] = $asiento;
                
        if($this->factura)
            foreach ($this->factura->asientos as $key => $asiento) $asientos_factura[] = $asiento;

        $asientos = array_merge($asientos_venta, $asientos_pagos,$asientos_factura);

        //dd( $asientos );

       return $asientos;
    }

    public function getDetallesGananciasAttribute()
    {
        $detalles = $this->detalles;
        $ganancias = array();
        foreach ($detalles as $key => $detalle)
        {
            $costo = $detalle->costo_unitario*$detalle->cantidad;

            $precio = $detalle->precio_unitario*$detalle->cantidad;

            $ganancias[] = $precio - $costo;  
        }

        return $ganancias;
    }

    public function getGananciaTotalAttribute()
    {
        $total = 0;
        foreach ($this->detalles_ganancias as $key => $ganancia) 
        $total += $ganancia;
        return $total;
    }

    public function getSumaTotalPagosAttribute()
    {
        $suma_total = 0;

        foreach ($this->pagos as $key => $pago) 
        {
            $suma_total += $pago->monto; 
        }

        return $suma_total;
    }

    public function getSumaTotalPagosFormatAttribute()
    {
        return number_format($this->suma_total_pagos, 0, '', '.');
    }

    public function getRestanteAPagarAttribute()
    {
        $monto_total = $this->monto_total;

        $suma_total_pagos = $this->suma_total_pagos;

        return ($monto_total-$suma_total_pagos);
    }

    public function getRestanteAPagarFormatAttribute()
    {
        return number_format($this->restante_a_pagar, 0, '', '.');
    }

    public function getFechaVentaFormatAttribute()
    {
        $date = $this->fecha_venta;
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }

    public function getTotalPagadoFormatAttribute()
    {
        $number = $this->total_pagado;
        return number_format($number, 0, '', '.');
    }

    public function getMontoTotalFormatAttribute()
    {
        $number = $this->monto_total;
        return number_format($number, 0, '', '.');
    }

    
    
    public function getTotalGrabadoAttribute()
   {
       $number = $this->grabado_excenta + $this->grabado_5 + $this->grabado_10 + $this->total_iva_10 + $this->total_iva_5;
       return $number;
       //return number_format($number, 0, '', '.');
   }

   public function getTipoEntidadAttribute()
   {
        return $this->tipo;
   }

   public function format($attribute, $type = 'number', $date_format = 'd/m/Y')
    {
        if($type == 'number')
            return number_format($this[$attribute], 0, '', '.');

        if($type == 'date')
            return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);
        
        else
            return ' format_number($attribute, $type=["number","date"]) ';
    }

    public function getAsientosButtonsAttribute()
    {
        $asientos = $this->asientos_all;

        $links = '';

        foreach ($asientos as $key => $asiento) 
        {
            $asiento_edit_route = route('admin.contabilidad.asiento.edit', $asiento->id);

            $links = $links.'<a href="'.$asiento_edit_route.'" class="btn btn-primary btn-flat">'.$asiento->operacion.' </a><br><br>'; 
        }

        return $links;


    }


    public function getFacturaButtonAttribute()
    {
        $factura = $this->factura;

        if($factura)
        {
            $factura_route = route('admin.ventas.facturaventa.edit', $factura->id);

            return ' <a href="'.$factura_route.'" class="btn btn-primary btn-flat"> VER FACTURA </a> ';
        }
        else 
        {
            $venta_edit_route = route('admin.ventas.venta.edit', $this->id);

            return ' <a href="'.$venta_edit_route.'" class="btn btn-primary btn-flat"> VER DETALLES DE PREVENTA </a> ';
        }
    }

    public function usuario_create()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id_create');
    }

    public function usuario_edit()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id_edit');
    }
    
    public function usuario_apellido_nombre($create_or_edit = 'create')
    {

        if($create_or_edit != 'create' && $create_or_edit != 'edit')return 'use "create" or "edit" on function';

        $usuario = $this['usuario_'.$create_or_edit];

        if(!$usuario)return null;

        $apellido_nombre = $usuario->last_name.' '.$usuario->first_name;

        return $apellido_nombre;
    }

}
