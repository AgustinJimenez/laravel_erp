<?php namespace Modules\Contabilidad\Entities;


use Illuminate\Database\Eloquent\Model;

class AsientoDetalle extends Model
{
    protected $table = 'contabilidad__asientodetalles';
    protected $fillable = 
    [
    	'asiento_id',
        'cuenta_id',
        'debe',
        'haber',
        'observacion'
    ];

    public function cuenta()
    {
        return $this->belongsTo('Modules\Contabilidad\Entities\Cuenta','cuenta_id');
    }

    public function asiento()
    {
        return $this->belongsTo('Modules\Contabilidad\Entities\Asiento','asiento_id');
    }

    public function getTipoCuentaAttribute()
    {
        return $this->cuenta->tipo_nombre;
    }

    public function getNaturalezaCuentaAttribute()
    {
        
        return $this->tipo_cuenta->naturaleza_cuenta;
    }

    public function getSaldoAttribute()
    {
        $debe = $this->debe;

        $haber = $this->haber;

        $naturaleza_cuenta = $this->naturaleza_cuenta;

        if($naturaleza_cuenta == 'deudor')

            return ($debe - $haber);

        else
            
            return ($haber - $debe);
    }

}
