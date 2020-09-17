<?php namespace Modules\Compras\Entities;

use Illuminate\Database\Eloquent\Model;

class Detallecompra extends Model
{
    protected $table = 'compras__detallecompras';
    protected $fillable = 
    [
    	'compra_id',
        'descripcion',
    	'producto_id',
    	'cantidad',
    	'precio_unitario',
    	'iva',
    	'precio_total'
    ];

     public function wformat($attribute = null, $n_decimals = 1, $mil = ".", $decimal = ",") 
    { 
        if($attribute) 
            return number_format( (double)$this[$attribute], $n_decimals, $decimal, $mil); 
        else 
            dd("wformat($attribute = null, $n_decimals = 2, $mil = ".", $decimal = ",")"); 
    } 
}
