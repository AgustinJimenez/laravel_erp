<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Asiento;
use DateTime, DB;
include( base_path().'/Modules/funciones_varias.php');

class FlujoEfectivoDetallesController extends AdminBaseController 
{
	
	public function flujo_efectivo_detalles(Request $re)
	{
		$fecha = date("Y-m-d", $re->date);

		$fecha = date_from_server($fecha);

		return view('contabilidad::admin.reportes.flujo-efectivo-detalle.index', compact('fecha'));
	}

	public function flujo_efectivo_detalles_ajax(Request $re)
	{
		$this->procesa_request($re);

		$query = $this->flujo_efectivo_detalles_query($re);

		$object = Datatables::of( $query )
            ->editColumn('fecha', function($tabla)
            {
            	return date_from_server($tabla->asiento->fecha);
            })
            ->editColumn('operacion', function($tabla)
            {
            	return $tabla->asiento->operacion;
            })
            ->editColumn('observacion', function($tabla)
            {
            	return $tabla->asiento->with_edit_link('observacion_reducida');
            })
            ->editColumn('debe', function($tabla)
            {
                return thousands_separator_dots($tabla->debe);
            })
            ->editColumn('haber', function($tabla)
            {
                return thousands_separator_dots($tabla->haber);
            })
            ->addColumn('saldo', function ($tabla) use ($re)
            {   
            	$re['saldo_acumulado_ai'] += $tabla->saldo;

            	return thousands_separator_dots($re['saldo_acumulado_ai']);
            })
            ->make( true );

        $data = $object->getData(true);

        $data['saldo_acumulado'] = thousands_separator_dots($re['saldo_acumulado']);

        $data['fecha_inicio'] = $re['fecha_inicio_menos_uno_format'];

        return response()->json( $data );
	}

	public function flujo_efectivo_detalles_excel(Request $re)
	{
		$this->procesa_request($re);

        $query = $this->flujo_efectivo_detalles_query($re);

        $query_clone = $query->get();

        foreach ($query_clone as $key => $registro) 
        {
        	$re['saldo_acumulado_ai'] += $registro->saldo;

            $registros[] = 
            [
                "Fecha" => $registro->asiento->format('fecha', 'date'),
                "Tipo-Operación" => $registro->asiento->operacion,
                "Observación" => $registro->asiento->observacion,
                "Debe" => $registro->debe,
                "Haber" => $registro->haber,
                "Saldo" => $re['saldo_acumulado_ai'],
                "Saldo Acumulado Hasta el ".$re['fecha_inicio_menos_uno_format'].': '.$re['saldo_acumulado'] => '',
                "Fecha Inicio: ".$re['fecha_inicio_format'] => '',
                "Fecha Fin: ".$re['fecha_fin_format'] => '',
                "Fecha de Doc: ".$re['fecha_hoy_format'] => ''
            ];
        }

        $registros = collect($registros);

        Excel::create('Reporte_Flujo_Efectivo_Detalles_'.$re['fecha_hoy'], function($excel) use ($registros) 
        {
            $excel->sheet('Flujo Efectivo Detalles', function($sheet) use ($registros) 
            {
                $sheet->fromArray($registros);
 
            });
        })->export('xls');
	}

	function procesa_request($re)
	{
		if( $re['fecha_inicio_excel'] )
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

		$re['fecha_inicio_object'] = date_create_from_format('Y-m-d', $re['fecha_inicio']);

		$re['fecha_fin_object'] = date_create_from_format('Y-m-d', $re['fecha_fin']);

		$re['fecha_inicio_anio'] = $re['fecha_inicio_object']->format('Y').'-01-01';

		$re['fecha_inicio_anio_format'] = date_from_server($re['fecha_inicio_anio']);

		$re['fecha_inicio_menos_uno'] = $re['fecha_inicio_object']->modify('-1 day')->format('Y-m-d');

		$re['fecha_inicio_menos_uno_format'] = $re['fecha_inicio_object']->format('d/m/Y');
		
		$re['saldo_acumulado'] = \CuentasFijas::get('flujoefectivo.saldo_acumulado.caja')->totalEjercicioContable($re['fecha_inicio_anio'], $re['fecha_inicio_menos_uno'])->saldo;

		$re['saldo_acumulado_ai'] = $re['saldo_acumulado'];
	}

	function flujo_efectivo_detalles_query($re)
	{
		$query = AsientoDetalle::join('contabilidad__asientos', 'contabilidad__asientos.id', '=', 'asiento_id')
								->join('contabilidad__cuentas as cuenta_hija', 'cuenta_hija.id', '=', 'contabilidad__asientodetalles.cuenta_id')
								->join('contabilidad__cuentas as cuenta_padre', 'cuenta_padre.id', '=', 'cuenta_hija.padre')
								->where('cuenta_padre.codigo', $re['codigo_padre'])
								->orderBy('contabilidad__asientos.fecha', 'ASC')
								->orderBy('contabilidad__asientodetalles.id', 'ASC');

		if ($re->has('fecha_inicio') && trim($re->has('fecha_inicio') !== '') )
            $query->where('contabilidad__asientos.fecha', '>', date_create_from_format('Y-m-d', $re['fecha_inicio'])->modify('-1 day'));
        

        if ($re->has('fecha_fin') && trim($re->has('fecha_fin') !== '') )
            $query->where('contabilidad__asientos.fecha', '<', date_create_from_format('Y-m-d', $re['fecha_fin'])  );

        $query->select
		([
			'contabilidad__asientodetalles.*'
		]);

		//dd($query->toSql());

        return $query;
	}
	
}