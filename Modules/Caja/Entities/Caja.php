<?php namespace Modules\Caja\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use stdClass;

class Caja extends Model
{

    protected $table = 'caja_cajas';
    protected $fillable = 
    [
        'created_at',
    	'apertura',
        'cierre',
    	'usuario_sistema_id',
    	'monto_inicial',
    	'activo'
    ];

    protected $appends = ['monto_inicial_formateado'];

    public function getMontoInicialFormateadoAttribute()
    {
        return number_format($this->attributes['monto_inicial'], 0, '', '.');
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

    public function getSumaMovimientosAttribute()
    {
        $movimientos = $this->movimientos;

        if( count($movimientos) == 0 )
            return 0;

        $suma_movimientos = 0;

        foreach ($movimientos as $key => $movimiento) 
        {
            $suma_movimientos += $movimiento->monto;
        }

        return $suma_movimientos;
    }

    public function movimientos()
    {
        return $this->hasMany('Modules\Caja\Entities\CajaMovimiento', 'caja_id', 'id')->orderBy('fecha_hora','desc');
    }

    public function getCreatedAtFormatAttribute()
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $this['created_at'])->format('d/m/Y H:i:s');
    }

    public function getCreatedAtFormatTimestampAttribute()
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $this['created_at'])->format('d/m/Y H:i:s');
    }

    public function getCierreFormatTimestampAttribute()
    {
        if($this['cierre'] == '0000-00-00 00:00:00')
            return '';
        else
            return DateTime::createFromFormat('Y-m-d H:i:s', $this['cierre'])->format('d/m/Y H:i:s');
    }

    public function ventas()
    {
        return $this->hasMany('Modules\Ventas\Entities\Venta', 'caja_id', 'id');
    }

    public function pagos()
    {
        return $this->hasMany('Modules\Pagofacturascredito\Entities\Pagofacturacredito', 'caja_id', 'id')->orderBy('created_at','asc');
    }

    public function pagos_forma_pago()
    {
        $pagos = $this->pagos;

        $pagos_efectivo = [];

        $pagos_cheque  = [];

        $pagos_tarjeta_credito = [];

        $tarjeta_debito = [];

        foreach ($pagos as $key => $pago) 
        {
            if($pago->forma_pago == 'efectivo')
                $pagos_efectivo[] = $pago;
            else if($pago->forma_pago == 'cheque')
                $pagos_cheque[] = $pago;
            else if($pago->forma_pago == 'tarjeta_credito')
                $pagos_tarjeta_credito[] = $pago;
            else if($pago->forma_pago == 'tarjeta_debito')
                $tarjeta_debito[] = $pago;
        }   

        //dd($pagos_tarjeta_credito);

        $var = new stdClass();

        $var->pagos_efectivo = $pagos_efectivo;
        $var->pagos_cheque = $pagos_cheque;
        $var->pagos_tarjeta_credito = $pagos_tarjeta_credito;
        $var->tarjeta_debito = $tarjeta_debito;

        return $var;
    }

    public function usuario()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'usuario_sistema_id');
    }

    //retorna el total de la suma de montos de los pagos pertenecientes a una forma de pago de la caja 
    public function get_total($forma_pago)
    {
        $pagos = $this->pagos;

        $total = 0;

        foreach ($pagos as $key => $pago) 
        {
            if($pago->forma_pago == $forma_pago)
            {
                $total += $pago->monto;
            }


        }

        //dd($montos);

        $var = new stdClass();

        $var->total =  $total;

        return $var;
    }

    //retorna el total de la suma de montos de los pagos de la caja 
    public function get_total_pagos()
    {
        $pagos = $this->pagos;

        $total = 0;

        foreach ($pagos as $key => $pago) 
        {
            
            $total += $pago->monto;

            $montos[] = $pago->monto;
        }

        //dd($montos);

        $var = new stdClass();

        $var->total =  $total;

        return $var;
    }

    public function getTotalPagosAttribute()
    {
        return $this->get_total_pagos()->total;
    }

    //retorna el total de la suma de montos de los pagos de la caja en formato
    public function getTotalPagosFormatAttribute()
    {
        return number_format($this->get_total_pagos()->total, 0, '', '.');
    }

    public function getTotalPagosPlusMontoInicialPlusMovimientosAttribute()
    {
        $monto_inicial = $this->monto_inicial;

        $total_pagos = $this->total_pagos;

        $suma_movimientos = $this->suma_movimientos;

        $total_general = $monto_inicial + $total_pagos + $suma_movimientos;

        return $total_general;
    }

    public function getTotalPagosPlusMontoInicialPlusMovimientosFormatAttribute()
    {
        return number_format($this->total_pagos_plus_monto_inicial_plus_movimientos, 0, '', '.');
    }

    //retorna el total de la suma de montos de los pagos pertenecientes a una forma de pago de la caja en formato
    public function get_total_format($forma_pago)
    {
        return number_format( $this->get_total($forma_pago)->total , 0, '', '.');
    }

    //retorna el total de la suma de montos totales de las ventas realizadas
    public function total_ventas()
    {
        $ventas = $this->ventas;

        $total_pagado_ventas = 0;

        foreach ($ventas as $key => $venta) 
        {
            $total_pagado = $venta->total_pagado;

            $total_pagado = str_replace('.', '', $total_pagado);

            $total_pagado_ventas += $total_pagado;
        }

        $var = new stdClass();

        $var->total_pagado_ventas =  number_format($total_pagado_ventas, 0, '', '.');

        return $var;
    }


}
