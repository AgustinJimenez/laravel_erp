<?php namespace Modules\Empleados\Entities;

use Illuminate\Database\Eloquent\Model;

class PagoEmpleado extends Model
{

    protected $table = 'empleados__pagoempleados';
    protected $fillable = 
    [
    	'salario',
        'anulado',
    	'extra',
    	'total',
    	'fecha',
    	'observacion',
    	'empleado_id',
    	'usuario_sistema_id',
        'monto_ips'

    ];

    public function asientos()
    {
        return $this->morphMany('Modules\Contabilidad\Entities\Asiento', 'entidad');
    }

    public function anticipos()
    {
        return $this->hasMany(\Anticipo::class, 'pago_empleado_id');
    }

    public function usuario()///Modules/User/Entities/Sentinel/User.php
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id');
    }

    public function empleado()
    {
        return $this->belongsTo('Modules\Empleados\Entities\Empleado', 'empleado_id');
    }






}
