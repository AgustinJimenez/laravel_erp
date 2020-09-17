<?php namespace Modules\Caja\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Datetime;

class CajaMovimiento extends Model 
{

	protected $table = 'caja_movimiento';	
    protected $fillable = 
    [
    	'tipo',
    	'caja_id',
    	'usuario_sistema_id',
    	'fecha_hora',
    	'monto',
    	'motivo'
    ];

    public function caja()
    {
        return $this->belongsTo('Modules\Caja\Entities\Caja', 'caja_id');
    }

    public function usuario_get()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id');
    }

    public function getUsuarioAttribute()
    {
        return $this->usuario_get->last_name.' '.$this->usuario_get->first_name;
    }

    public function getMontoFixedAttribute()
    {
        $monto = $this->monto;

        if($monto<0)
            $monto = $monto*-1;

        return $monto;
    }

    public function format($attribute, $type = 'number', $date_format = 'd/m/Y')
    {
        if($type == 'number')
            return number_format($this[$attribute], 0, '', '.');

        if($type == 'date')
            return DateTime::createFromFormat('Y-m-d', $this[$attribute])->format($date_format);

        if($type == 'datetime')
            return DateTime::createFromFormat('Y-m-d H:i:s', $this[$attribute])->format('d/m/Y H:i:s');
        
        else
            return ' format_number($attribute, $type=["number","date", "datetime"]) ';
    }
}