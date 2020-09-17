<?php namespace Modules\Ventas\Entities;
   
use Illuminate\Database\Eloquent\Model;

class ConfigFacturaVenta extends Model {

	protected $table = 'ventas_config_factura';
    protected $fillable = 
    [
    	'identificador',
    	'nombre',
    	'valor'
    ];

}