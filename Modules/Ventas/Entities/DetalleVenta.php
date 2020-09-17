<?php namespace Modules\Ventas\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Ventas\Entities\DetalleVenta;

class DetalleVenta extends Model
{


    protected $table = 'ventas__detalleventas';
    protected $fillable = 
    [
    	'venta_id',
    	'cantidad',
    	'producto_id',
    	'servicio_id',
    	'cristal_id',
        'descripcion',
    	'precio_unitario',
    	'precio_total',
    	'ojo_izq', 
    	'ojo_der',
    	'distancia_interpupilar',
        'iva',
        'costo_unitario'
    ];

    public function getPrecioUnitarioFormatAttribute()
    {
        return number_format($this->precio_unitario, 0, '', '.');
    }

    public function wformat($attribute = null, $n_decimals = 1, $mil = ".", $decimal = ",")
    {
        if($attribute)
            return number_format( (double)$this[$attribute], $n_decimals, $decimal, $mil);
        else
            dd("wformat($attribute = null, $n_decimals = 2, $mil = ".", $decimal = ",")");
    }

    public function getPrecioTotalFormatAttribute()
    {
        return number_format($this->precio_total, 0, '', '.');
    }

    public function producto()
    {
        return $this->belongsTo('Modules\Productos\Entities\Producto','producto_id');
    }

    public function servicio()
    {
        return $this->belongsTo('Modules\Servicios\Entities\Servicio','servicio_id');
    }
    
    public function cristal()
    {
        return $this->belongsTo('Modules\Cristales\Entities\Cristales', 'cristal_id');
    }

    public function tipo_cristal()
    {
        return $this->belongsTo('Modules\Cristales\Entities\TipoCristales', 'cristal_id');
    }

    public function getDescripcionProductoAttribute()
    {
        if($this['producto'])
            return $this->producto->nombre . " -Codigo: " . $this->producto->codigo . " -Marca: " . $this->producto->marca->nombre;
        else if($this['servicio'])
            return $this->servicio->nombre;
        else if($this['tipo_cristal'])
            return $this->tipo_cristal->descripcion;
         else
             return $this->descripcion;
            //return DetalleVenta::where('id',$this->id)->get()->first();
    }

    public function getIvaFormatAttribute()
    {
        if($this->iva == 11)
            return 10;
        else if($this->iva == 21)
            return 5;
        else
            return 0;
    }
}
