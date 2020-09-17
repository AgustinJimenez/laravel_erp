<?php namespace Modules\Contabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model
{
    protected $table = 'contabilidad__tipocuentas';
    protected $fillable = 
    [
    	'codigo',
    	'nombre'
    ];
}
