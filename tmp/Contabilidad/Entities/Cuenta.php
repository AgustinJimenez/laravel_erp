<?php namespace Modules\Contabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'contabilidad__cuentas';
    protected $fillable = [
    						'codigo',
    						'nombre',
    						'padre',
    						'tiene_hijo',
    						'activo',
    						'tipo'
						  ];


	public function padre_nombre()
	{
		return $this->belongsTo('Modules\Contabilidad\Entities\Cuenta','padre');
	}

}
