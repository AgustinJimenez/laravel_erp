<?php namespace Modules\Compras\Entities;

use Illuminate\Database\Eloquent\Model;

use DateTime, stdClass;

class Compra extends Model
{

    protected $table = 'compras__compras';
    protected $fillable = 
    [
    	'nro_factura',
        'tipo',
    	'timbrado',
        'anulado',
    	'proveedor_id',
    	'razon_social',
    	'ruc_proveedor',
    	'fecha',
    	'tipo_factura',
    	'monto_total',
    	'monto_total_letras',
	    'grabado_excenta',
        'grabado_5',
        'grabado_10',
        'total_iva_5',
    	'total_iva_10',
    	'total_iva',
    	'observacion',
    	'total_pagado',
    	'comprobante',
    	'moneda',
    	'cambio',
    	'pagado_por',
    	'comentario_pagado_por',
    	'usuario_sistema_id',
        'usuario_sistema_id_edit'
    ];
    
    public function proveedor()
    {
        return $this->belongsTo('Modules\Proveedores\Entities\Proveedor','proveedor_id');
    }

    public function usuario_create()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id');
    }

    public function usuario_edit()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id_edit');
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

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function getTotalPagadoPagosAttribute()
    {
        $suma_total_pagos = 0;

        foreach ($this->pagos as $key => $pago) 
            $suma_total_pagos += $pago->monto;
        
        return $suma_total_pagos;
    }

    public function pagos()
    {
        return $this->hasMany('Modules\Compras\Entities\CompraPago', 'compra_id');
    }

    public function getAsientosAllAttribute()
    {
        $asientos_compra = []; $asientos_pagos = [];

        foreach ($this->asientos as $key => $asiento) $asientos_compra[] = $asiento;

        foreach ($this->pagos as $key => $pago) 
            if(count($pago->asientos)>0) 
                foreach ($pago->asientos as $key2 => $asiento) 
                    $asientos_pagos[] = $asiento;
        

        $asientos = array_merge($asientos_compra, $asientos_pagos);

        //dd( $asientos );

       return $asientos;
    }


    public function getPendienteAttribute()
    {
        $total_pagado = $this->total_pagado;

        $monto_a_pagar = $this->monto_total;

        if($total_pagado<$monto_a_pagar)
            return true;
        else
            return false;
    }

    public function detalles()
    {
        return $this->hasMany('Modules\Compras\Entities\Detallecompra', 'compra_id');
    }

    
 
    public function getFechaCompraAttribute() 
    { 
        $date = $this->fecha;

        return DateTime::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    } 
    
    //  public function grabados_compra()
    // {
    //     $total_iva_10 = 0;

    public function getSumaTotalPagosAttribute()
   {
       $suma_total = 0;        

       foreach ($this->pagos as $key => $pago)
       {
           $suma_total += $pago->monto;
       }        return $suma_total;
   }   

    public function getSumaTotalPagosFormatAttribute()
   {
       return number_format($this->suma_total_pagos, 0, '', '.');
   }    

    public function getRestantePagarAttribute()
    {
        $monto_total = $this->monto_total; 
 
        $suma_total_pagos = $this->suma_total_pagos; 

        $restante_pagar = $monto_total-$suma_total_pagos;

        if($restante_pagar<0)$restante_pagar=0;

        return $restante_pagar;
    }

    public function getRestantePagarFormatAttribute()
    {
        return number_format($this->restante_pagar, 0, '', '.');
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

    public function getTotalGrabadoIvaAttribute()
    {
        $number = $this->grabado_excenta + $this->grabado_5 + $this->grabado_10 + $this->total_iva_10 + $this->total_iva_5;
        return $number;
        return number_format($number, 0, '', '.');
    }

    public function format($attribute, $type, $date_format = 'd/m/Y')
    {
        if($type == 'number')
            return number_format($this[$attribute], 0, '', '.');

        if($type == 'date')
            return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);
        
        else
            return ' format_number($attribute, $type=["number","date"]) ';
    }

    public function getTipoEntidadAttribute()
    {
        return 'compra';
    }
    
    public function getAsientoEditRoutesAttribute()
    {
        $asientos = $this->asientos;

        if(!$asientos)
            return '';
        
        $routes = null;

        foreach ($asientos as $key => $asiento) 
        {
            $routes[] = route('admin.contabilidad.asiento.edit', $asiento->id);
        }
        
        return $routes;
    }


    public function getFacturaButtonAttribute()
    {
        $factura_route = route('admin.compras.compra.factura', $this->id);

        return ' <a href="'.$factura_route.'" class="btn btn-primary btn-flat"> VER FACTURA </a> ';
        
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
}
