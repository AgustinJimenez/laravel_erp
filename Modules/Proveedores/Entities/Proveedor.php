<?php namespace Modules\Proveedores\Entities;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores__proveedors';
    protected $fillable = 
    [
    	'nombre',
        'razon_social',
        'ruc',
        'direccion',
        'email',
        'telefono',
        'celular',
        'fax',
        'contacto',
        'categoria'
    ];
}
