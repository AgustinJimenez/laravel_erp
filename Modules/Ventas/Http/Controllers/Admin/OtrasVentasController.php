<?php namespace Modules\Ventas\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Modules\Ventas\Entities\Venta;
use Yajra\Datatables\Facades\Datatables;
include( base_path().'/Modules/funciones_varias.php');
use DB;


class OtrasVentasController extends AdminBaseController 
{
	
	public function index()
	{
		return view('ventas::admin.otras-ventas.index');
	}

	public function index_ajax(Request $re)
	{
		$this->procesa_request($re);

        $query = $this->crear_query();

        $query = $this->filtra_query($re, $query);
 
        $object = $this->crear_datatable_object($query);

        return $object;
	}

	function procesa_request($re)
	{
		if($re['fecha_inicio'])
		{
			$re['fecha_inicio_format'] = $re['fecha_inicio'];

			$re['fecha_inicio'] = date_to_server( $re['fecha_inicio'] );

			$re['fecha_inicio_menos_uno'] = date_create_from_format('Y-m-d', $re['fecha_inicio'])->modify('-1 day')->format('Y-m-d');
		}
		
		if($re['fecha_fin'])
		{
			$re['fecha_fin'] = date_to_server( $re['fecha_fin'] );

			$re['fecha_fin_format'] = $re['fecha_fin'];
		}

	}

	function filtra_query($re, $query)
	{
		//dd( $re->all() );

		if ($re->has('fecha_inicio') && trim($re->has('fecha_inicio') !== '') )
            $query->where('ventas__ventas.fecha_venta', '>', $re['fecha_inicio_menos_uno']  );
                
        if ($re->has('fecha_fin') && trim($re->has('fecha_fin') !== '') )
            $query->where('ventas__ventas.fecha_venta', '<', $re['fecha_fin']  );
    
        if ($re->has('nro_seguimiento')  && trim($re->has('nro_seguimiento') !== '') )
            $query->where('nro_seguimiento', 'like', "%{$re['nro_seguimiento']}%");

        if ($re->has('razon_social')  && trim($re->has('razon_social') !== '') )
            $query->where('razon_social', 'like', "%{$re['razon_social']}%");

        if ($re->has('nro_factura')  && trim($re->has('nro_factura') !== '') )
            $query->where('ventas__facturaventas.nro_factura', 'like', "%{$re['nro_factura']}%");
        
        if ($re->has('anulado')  && trim($re->has('anulado') !== '') )
            $query->where('ventas__ventas.anulado', $re['anulado']);

        return $query;
	}

	function crear_query()
	{
		$query = Venta::join('clientes__clientes','clientes__clientes.id','=','cliente_id')
                    ->leftjoin('ventas__facturaventas','ventas__facturaventas.venta_id','=','ventas__ventas.id')
                    ->leftjoin('users','users.id','=','ventas__ventas.usuario_sistema_id_create')
                    ->where('ventas__ventas.tipo','otros')
                    ->select('ventas__ventas.*',
                             'ventas__facturaventas.nro_factura as nro_factura',
                             'clientes__clientes.razon_social', 
                             DB::raw('CONCAT(users.last_name," ",users.first_name) as creado_por'),
                             'ventas__facturaventas.id as factura_id');
        return $query;
	}

	function crear_datatable_object($query)
	{
		return $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla)
            {
                $asEdit = "admin.ventas.facturaventa.edit";

                $editRoute = route($asEdit, [$tabla->factura->id]);

                $buttons=	"<div class='btn-group' style='aligh:center;''>

                				<a href='".$editRoute." ' class='btn btn-default btn-flat'>

                                    <strong>VER DETALLES</strong>

                                </a>

                            </div>";

                return $buttons;
            })
            ->editColumn('anulado',function($tabla)
            {
                if($tabla->anulado)
                    return "SI";
                else
                    return "NO";
            })
            ->editColumn('total_pagado', function($tabla)
            {
                return thousands_separator_dots($tabla->total_pagado);
            })
            ->editColumn('monto_total', function($tabla)
            {
                return thousands_separator_dots($tabla->monto_total);
            })
            ->editColumn('razon_social', function($tabla)
            {
                return $tabla->razon_social;
            })
            ->editColumn('fecha_venta', function($tabla)
            {
                return $tabla->format('fecha_venta', 'date');
            })
            ->editColumn('descripcion', function($tabla)
            {
                return $tabla->descripcion;
            })
           
            ->make(true);
	}


	
}