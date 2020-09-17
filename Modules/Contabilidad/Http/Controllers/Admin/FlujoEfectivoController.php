<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Asiento;
use DateTime;

include( base_path().'/Modules/funciones_varias.php');

class FlujoEfectivoController extends AdminBaseController 
{
	
	public function flujo_efectivo()
	{
		$fecha_actual = new DateTime('now');

		$fecha_inicio_mes = "01" . $fecha_actual->format('/m/Y');

		$fecha_actual = $fecha_actual->format('d/m/Y');

		return view('contabilidad::admin.reportes.flujo-efectivo.index', compact('fecha_inicio_mes', 'fecha_actual'));
	}

	public function flujo_efectivo_ajax(Request $re)
	{
		$re = $this->procesa_request($re);

        $query = $this->flujo_efectivo_query($re);

        $query_clone = $query->get();

        foreach ($query_clone as $key => $registro) 
        {
        	$ejercicio = Cuenta::where('codigo', $re['codigo_padre'])->first()->totalEjercicioContable($registro->asiento->fecha, $registro->asiento->fecha);

        	$registro->debe_tmp = $ejercicio->debe;

        	$registro->haber_tmp = $ejercicio->haber;

        	$re['saldo_acumulado_ai'] += ($registro->debe_tmp - $registro->haber_tmp);

        	$registro->saldo_tmp =  $re['saldo_acumulado_ai'];
        }

        $object = Datatables::of( $query )
            ->editColumn('fecha', function($tabla)
            {
            	$fecha = date_from_server($tabla->asiento->fecha);

            	$fecha = $this->with_link($fecha);

            	$fecha = $this->with_formulario($fecha);

                return $fecha;
            })
            ->editColumn('debe', function($tabla) use ($query_clone, $re)
            {
            	$debe = $query_clone->where('id', $tabla->id)->first()->debe_tmp;

                return thousands_separator_dots($debe);
            })
            ->editColumn('haber', function($tabla) use ($query_clone, $re)
            {
            	$haber = $query_clone->where('id', $tabla->id)->first()->haber_tmp;

                return thousands_separator_dots($haber);
            })
            ->addColumn('saldo', function ($tabla) use ($query_clone, $re)
            {   
            	//dd($query_clone)
            	$saldo = $query_clone->where('id', $tabla->id)->first()->saldo_tmp;

            	//dd($saldo);

                return thousands_separator_dots( $saldo  );
            })
            ->make( true );

        $data = $object->getData(true);
        //dd($re['fecha_inicio_menos_uno_format']);
        $data['fecha_inicio'] = $re['fecha_inicio_menos_uno_format'];

        $data['saldo_acumulado'] = thousands_separator_dots($re['saldo_acumulado']);

        return response()->json( $data );
	}

    public function flujo_efectivo_excel(Request $re)
    {
        $re = $this->procesa_request($re);

        $query = $this->flujo_efectivo_query($re);

        $query_clone = $query->get();

        foreach ($query_clone as $key => $registro) 
        {
            $ejercicio = Cuenta::where('codigo', $re['codigo_padre'])->first()->totalEjercicioContable($registro->asiento->fecha, $registro->asiento->fecha);

            $registro->debe_tmp = $ejercicio->debe;

            $registro->haber_tmp = $ejercicio->haber;

            $re['saldo_acumulado_ai'] += ($registro->debe_tmp - $registro->haber_tmp);

            $registro->saldo_tmp =  $re['saldo_acumulado_ai'];

            $registros[] = 
            [
                "Fecha" => $registro->asiento->format('fecha', 'date'),
                "Debe" => $registro->debe_tmp,
                "Haber" => $registro->haber_tmp,
                "Saldo" => $registro->saldo_tmp,
                "Saldo Acumulado Hasta el ".$re['fecha_inicio_menos_uno_format'].': '.$re['saldo_acumulado'] => '',
                "Fecha Inicio: ".$re['fecha_inicio_format'] => '',
                "Fecha Fin: ".$re['fecha_fin_format'] => '',
                "Fecha de Doc: ".$re['fecha_hoy_format'] => ''
            ];
        }

        $registros = collect($registros);

        Excel::create('Reporte_Flujo_Efectivo_'.$re['fecha_hoy'], function($excel) use ($registros) 
        {
            $excel->sheet('Flujo Efectivo', function($sheet) use ($registros) 
            {
                $sheet->fromArray($registros);
 
            });
        })->export('xls');
    }
	
    function procesa_request($re)
    {
        if($re['fecha_inicio_excel'])
        {
            $re['fecha_inicio'] = $re['fecha_inicio_excel'];

            $re['fecha_fin'] = $re['fecha_fin_excel'];      
        }

        $re['codigo_padre'] = \CuentasFijas::get('caja_padre')->codigo;

        $re['fecha_inicio_format'] = $re['fecha_inicio'];

        $re['fecha_fin_format'] = $re['fecha_fin'];

        $re['fecha_hoy'] = date('Y-m-d');

        $re['fecha_hoy_format'] = date('d/m/Y');

        $re['fecha_inicio'] = date_to_server($re['fecha_inicio']);
    
        $re['fecha_fin'] = date_to_server($re['fecha_fin']);

        $re['fecha_inicio_anio'] = date_create_from_format('Y-m-d', $re['fecha_inicio'])->format('Y').'-01-01';

        $re['fecha_inicio_anio_format'] = date_create_from_format('Y-m-d', $re['fecha_inicio_anio'])->format('d/m/Y');

        $re['fecha_inicio_menos_uno'] = date_create_from_format('Y-m-d', $re['fecha_inicio'])->modify('-1 day')->format('Y-m-d');

        $re['fecha_inicio_menos_uno_format'] = date_create_from_format('Y-m-d', $re['fecha_inicio'])->modify('-1 day')->format('d/m/Y');

        $re['saldo_acumulado'] = Cuenta::where('codigo', $re['codigo_padre'])->first()->totalEjercicioContable($re['fecha_inicio_anio'], $re['fecha_inicio_menos_uno'])->saldo;

        $re['saldo_acumulado_ai'] = $re['saldo_acumulado'];

        return $re;
    }

    function with_link($element)
    {
        return $element_with_link = '<a class="to_detalles">' . $element . '</a>';
    }

    function with_formulario($element)
    {
        return $element_with_formulario = $element. ' ' . $this->get_formulario_detalles();
    }

    function get_formulario_detalles()
    {
        $base_path = 'admin.contabilidad.reportes.';

        $as_historial = $base_path."flujo_efectivo_detalles";

        $historial_route = route( $as_historial );

        $formulario = '<form action="'.$historial_route.'" method="get" target="_blank">
                            <input type="hidden" name="date">
                        </form>';

        return $formulario;
    }

    function flujo_efectivo_query($re)
    {
        $query = AsientoDetalle::join('contabilidad__asientos', 'contabilidad__asientos.id', '=', 'asiento_id')
                                ->join('contabilidad__cuentas as cuenta_hija', 'cuenta_hija.id', '=', 'contabilidad__asientodetalles.cuenta_id')
                                ->join('contabilidad__cuentas as cuenta_padre', 'cuenta_padre.id', '=', 'cuenta_hija.padre')
                                ->where('cuenta_padre.codigo', $re['codigo_padre'])
                                ->orderBy('contabilidad__asientos.fecha', 'ASC')
                                ->orderBy('contabilidad__asientodetalles.id', 'ASC')
                                ->groupBy('contabilidad__asientos.fecha');

        if ($re->has('fecha_inicio') && trim($re->has('fecha_inicio') !== '') )
            $query->where('fecha', '>', date_create_from_format('Y-m-d', $re['fecha_inicio'])->modify('-1 day'));
        

        if ($re->has('fecha_fin') && trim($re->has('fecha_fin') !== '') )
            $query->where('fecha', '<', date_create_from_format('Y-m-d', $re['fecha_fin'])  );

        $query->select(['contabilidad__asientodetalles.*']);

        return $query;
    }
}