<?php namespace Modules\Productos\Entities;


use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'productos__categoriaproductos';
    protected $fillable = 
    [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public function producto()
    {
        return $this->hasMany('Modules\Productos\Entities\Producto', 'categoria_id');
    }
}
