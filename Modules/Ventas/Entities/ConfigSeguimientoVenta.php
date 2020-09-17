<?php namespace Modules\Ventas\Entities;
   
use Illuminate\Database\Eloquent\Model;

class ConfigSeguimientoVenta extends Model {

	protected $table = 'ventas_config_seguimiento';
    protected $fillable = 
    [
    	'nro_1',
    	'nro_2'
    ];

}