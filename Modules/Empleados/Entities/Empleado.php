<?php namespace Modules\Empleados\Entities;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $table = 'empleados__empleados';
    protected $fillable = 
    [
    	'nombre',
    	'apellido',
        'cedula',
        'cargo',
        'ruc',
        'direccion',
        'email',
        'telefono',
        'celular',
        'activo',
        'salario',
        'ips'
    ];


    public function pagoempleado()
    {
        return $this->hasMany('Modules\Empleados\Entities\PagoEmpleado');
    }

    public function getNombreApellidoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function anticipos()
    {
        return $this->hasMany(\Anticipo::class, "empleado_id");
    }
}
