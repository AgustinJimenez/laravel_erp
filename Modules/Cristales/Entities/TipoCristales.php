<?php namespace Modules\Cristales\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoCristales extends Model
{
    protected $table = 'cristales__tipocristales';
    
    protected $fillable = 
    [
    	'nombre',
    	'codigo',
    	'categoria_cristal_id',
    	'cristal_id',
    	'descripcion',
    	'precio_costo',
    	'precio_venta',
    	'activo'

    ];

    public function cristal()
    {
        return $this->belongsTo('Modules\Cristales\Entities\Cristales', 'cristal_id');
    }
    
    public function categoria()
    {
        return $this->belongsTo('Modules\Cristales\Entities\CategoriaCristales', 'categoria_cristal_id');
    }

    public function detalles_ventas()
    {
        return $this->hasMany('Modules\Ventas\Entities\DetalleVenta', 'cristal_id');
    }

    public function getDescripcionAttribute()
    {
        $categoria_nombre = $this->categoria->nombre;
        $cristal_nombre = $this->cristal->nombre;
        $tipo_nombre = $this->nombre;
        return $descripcion = "{$categoria_nombre} {$cristal_nombre} {$tipo_nombre}";


    }
}
