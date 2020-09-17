<?php namespace Modules\Productos\Entities;


use Illuminate\Database\Eloquent\Model;
use DateTime;

class AltabajaProducto extends Model
{

    protected $table = 'productos__altabajaproductos';
    protected $fillable = 
    [
    	'producto_id',
    	'operacion',
    	'descripcion',
    	'cantidad',
    	'fecha',
        'usuario_sistema_id',

    ];

   // protected $appends = ['fecha'];


    public function producto()
    {
        return $this->belongsTo('Modules\Productos\Entities\Producto', 'producto_id');
    }

    public function usuario()///Modules/User/Entities/Sentinel/User.php
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id');
    }

    public function getFechaAttribute()
    {
        $date = $this->attributes['fecha'];
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObject->format('d/m/Y');
    }



}
