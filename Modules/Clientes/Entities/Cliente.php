<?php namespace Modules\Clientes\Entities;


use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes__clientes';
    protected $fillable = 
    [
    	'nombre_apellido',
        'razon_social',
        'cedula',
        'ruc',
        'direccion',
        'email',
        'telefono',
        'celular',
        'activo'
    ];

    public function ventas()
    {
        return $this->hasMany(\Venta::class, "cliente_id");
    }
}
