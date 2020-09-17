<?php namespace Modules\Servicios\Entities;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{


    protected $table = 'servicios__servicios';

    protected $fillable = 
    [
    	'nombre',
    	'codigo',
    	'descripcion',
    	'precio_venta',
    	'activo'

    ];

    public function getPrecioVentaAttribute()
    {
        $precio_venta = $this->attributes['precio_venta'];

        $precio_venta = number_format($precio_venta,0,"",".");

        return $precio_venta;
    }

}
