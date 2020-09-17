<?php namespace Modules\Contabilidad\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Contabilidad\Entities\Asiento;
use Session,DB;
use stdClass;

class Cuenta extends Model
{
    protected $table = 'contabilidad__cuentas';
    protected $fillable = [
    						'codigo',
    						'nombre',
    						'padre',
    						'tiene_hijo',
    						'activo',
    						'tipo',
                            'profundidad'
						  ];


	public function padre_nombre()
	{
		return $this->belongsTo('Modules\Contabilidad\Entities\Cuenta','padre');
	}

    public function tipo_nombre()
    {
        return $this->belongsTo('Modules\Contabilidad\Entities\TipoCuenta','tipo');
    }

    public function getCodigoPadreAttribute()
    {
        return $this->padre_nombre->codigo;
    }

    public function hijos()
    {
        $hijos = $this->hasMany('Modules\Contabilidad\Entities\Cuenta','padre','id');

        return $hijos;
    }
    
    public function getAsientosDetallesHijosAttribute()
    {
        $asientos = array();

        foreach ($this->hijos as $key => $hijo) 
            array_push($asientos, $hijo->asientos_detalles);
        
        return $asientos;
    }

    public function getCodigoNombreAttribute()
    {
        return $this->codigo . ' -' . $this->nombre;
    }

    public function asientos_detalles()
    {
        return $this->hasMany('Modules\Contabilidad\Entities\AsientoDetalle','cuenta_id');
    }

    public function getTotalDebeAttribute()
    {
        return $this->totalEjercicioContable()->debe;
    }

    public function getTotalHaberAttribute()
    {
        return $this->totalEjercicioContable()->haber;
    }

    public function getTotalSaldoAttribute()
    {
        return $this->totalEjercicioContable()->saldo;
    }
    public function getRelacionCuentasFijasAttribute()
    {
        $hijo_tiene_relacion_cuenta_fija = false;
        if($this->tiene_hijo)
            foreach ($this->hijos as $hijo) 
                if($hijo->relacion_cuentas_fijas)
                {
                    $hijo_tiene_relacion_cuenta_fija = true;
                    break;
                }

        if($this->is_cuenta_fija || $hijo_tiene_relacion_cuenta_fija)
            return true;
        else
            return false;
    }
    public function getIsCuentaFijaAttribute()
    {
        $cuentas_fijas_array = \CuentasFijas::get();
        $is_cuenta_fija = in_array( $this->codigo, $cuentas_fijas_array );
        return $is_cuenta_fija;
    }
    public function totalEjercicioContable($fecha_inicio = null, $fecha_fin = null)
    {
        //$fecha_inicio = Session::get('ejercicio')."-01-01", $fecha_fin = Session::get('ejercicio')."-12-31"
        $id_cuenta = $this->id;

        $ejercicio_contable = Session::get('ejercicio');

        if($fecha_inicio && $fecha_inicio!='')
            $fecha_desde = $fecha_inicio;
        else
            $fecha_desde = $ejercicio_contable."-01-01";

        if($fecha_fin && $fecha_fin!='')
            $fecha_hasta = $fecha_fin;
        else
            $fecha_hasta = $ejercicio_contable."-12-31";

            $fecha_ini = date('Y-m-d',strtotime($fecha_desde));
            $fecha_fin = date('Y-m-d',strtotime($fecha_hasta));

        if($this->tiene_hijo==0)
        {
            
            $suma = DB::table('contabilidad__asientodetalles')
                ->join('contabilidad__asientos','contabilidad__asientos.id','=','contabilidad__asientodetalles.asiento_id')
                ->where('contabilidad__asientos.fecha', '>=',$fecha_ini)
                ->where('contabilidad__asientos.fecha','<=',$fecha_fin )
                ->where('contabilidad__asientodetalles.cuenta_id',$id_cuenta)
                    ->select
                    ([
                        'contabilidad__asientodetalles.cuenta_id as cuenta_id',
                        'cuenta_id', DB::raw('SUM(debe) as debe'),
                        'cuenta_id', DB::raw('SUM(haber) as haber')
                    ])
                ->groupBy('contabilidad__asientodetalles.cuenta_id')
                ->get();

            if ($suma!=null) 
            {
                $naturaleza_cuenta = Cuenta::where('id', $this->id)->first()->tipo_nombre->naturaleza_cuenta;

                if( $naturaleza_cuenta == 'deudor')
                    $suma[0]->saldo = $suma[0]->debe - $suma[0]->haber;
                else if($naturaleza_cuenta == 'acreedor')
                    $suma[0]->saldo = $suma[0]->haber - $suma[0]->debe;

                return $suma[0];
            }
            else
            {
                $var = new stdClass();
                $var->cuenta_id=$this->id;
                $var->debe=0;
                $var->haber=0;
                $var->saldo = 0;
                return $var;
            }         
        } 

        else   
        {   
            $debe=0;
            $haber=0;
            $debe_local=0;
            $haber_local=0;
            $debe_n = DB::table('contabilidad__asientodetalles')
                ->join('contabilidad__asientos','contabilidad__asientos.id','=','contabilidad__asientodetalles.asiento_id')
                ->where('contabilidad__asientos.fecha','<=',$fecha_fin )
                ->where('contabilidad__asientos.fecha', '>=',$fecha_ini)
                ->where('contabilidad__asientodetalles.cuenta_id',$id_cuenta)
                ->select(DB::raw('SUM(debe) as debe'))->lists('debe');

            if ($debe_n[0]==null)
            {   
                $debe_n=0;
                $debe_local+=$debe_n;
            }
            else
            {
                $debe_local+=$debe_n[0];
            }
            $haber_n =DB::table('contabilidad__asientodetalles')
                ->join('contabilidad__asientos','contabilidad__asientos.id','=','contabilidad__asientodetalles.asiento_id')
                ->where('contabilidad__asientos.fecha','<=',$fecha_fin )
                ->where('contabilidad__asientos.fecha', '>=',$fecha_ini)
                ->where('contabilidad__asientodetalles.cuenta_id',$id_cuenta)
            ->select(DB::raw('SUM(haber) as haber'))->lists('haber');
            //dd($haber_n[0]);
            if ($haber_n[0]==null) 
            {
                $haber_n=0;
                $haber_local+=$haber_n;
            }
            else
            {
                $haber_local+=$haber_n[0];
            }
            //dd($haber_local);
            $hijos = $this->hijos;
            
            foreach ($hijos as $hijo) 
            {   
                //dd($fecha_ini.'----'.$fecha_fin);
                $suma=$hijo->totalEjercicioContable($fecha_ini, $fecha_fin);
                $debe+= $suma->debe;
                $haber+= $suma->haber;
            }

            $var = new stdClass();
            $var->cuenta_id = $this->id;
            $var->debe = $debe+$debe_local;
            $var->haber = $haber+$haber_local;
            $var->saldo = 0;
            
            $naturaleza_cuenta = Cuenta::where('id', $this->id)->first()->tipo_nombre->naturaleza_cuenta;

            if( $naturaleza_cuenta == 'deudor')
                $var->saldo = ($debe+$debe_local) - ($haber+$haber_local);
            else if($naturaleza_cuenta == 'acreedor')
                $var->saldo = ($haber+$haber_local) - ($debe+$debe_local);

            return $var;
        }   
            
    }
    
}
