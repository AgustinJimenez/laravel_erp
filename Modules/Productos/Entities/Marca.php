<?php namespace Modules\Productos\Entities;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'productos__marcas';
    protected $fillable = 
    [
    	'nombre',
    	'codigo',
    	'descripcion'
    ];

    public function producto()
    {
        return $this->hasMany('Modules\Productos\Entities\Producto','marca_id');
    }
}
