<?php namespace Modules\Pagofacturascredito\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Pagofacturascredito\Entities\Pagofacturacredito;
use Modules\Pagofacturascredito\Repositories\PagofacturacreditoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
include( base_path().'/Modules/funciones_varias.php');
use Modules\Pagofacturascredito\Http\Requests\PagoRequest;
use Modules\Ventas\Entities\Venta;
use Modules\Caja\Entities\Caja;
use Modules\Ventas\Entities\FacturaVenta;
use Modules\Core\Contracts\Authentication;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Cuenta;
use DB,Input;

class PagofacturacreditoController extends AdminBaseController
{
    /**
     * @var PagofacturacreditoRepository
     */
    private $pagofacturacredito;

    public function __construct(PagofacturacreditoRepository $pagofacturacredito)
    {
        parent::__construct();

        $this->pagofacturacredito = $pagofacturacredito;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('pagofacturascredito::admin.pagofacturacreditos.index');
    }

    public function index_ajax(Request $request)
    {
        $query = Pagofacturacredito::join('ventas__ventas','ventas__ventas.id','=','ventas_pago_factura_credito.venta_id')
                                    ->join('caja_cajas','caja_cajas.id','=','ventas_pago_factura_credito.caja_id')
        ->select([
                    'ventas_pago_factura_credito.id as id', 
                    'ventas_pago_factura_credito.fecha as fecha', 
                    'ventas_pago_factura_credito.monto as monto'
                ]);

        //dd( $query->get() );

        $columns = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $base_path = "admin.pagofacturascredito.pagofacturacredito";

                $asEdit = $base_path.".edit";

                $asDestroy = $base_path.".destroy";

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $buttons="<div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute ."'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </div>";

                return $buttons;
            })
            ->filter(function ($query) use ($request)
            {
                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') != '') )
                {
                    $query->where('ventas_pago_factura_credito.fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
                }

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') != '') )
                {
                    $query->where('ventas_pago_factura_credito.fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                }
            })
            ->editColumn('fecha', function($tabla)
            {
                return date("d/m/Y", strtotime(str_replace('/', '-', $tabla->fecha)));
            })
            ->editColumn('monto', function($tabla)
            {
                return number_format($tabla->monto, 0, '', '.');
            })
            ->make(true);

        return $columns;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $re)
    {
        //dd( $re->all() );

        $venta_id = $re['venta_id'];

        $caja_id = $re['caja_id'];

        $factura_id = $re['factura_id'];

        $pendiente = $re['pendiente'];

        $fecha = get_actual_date();

        $factura_venta = FacturaVenta::where('id', $factura_id)->first();

        //dd($factura_venta);

        return view('pagofacturascredito::admin.pagofacturacreditos.create', compact('fecha','caja_id','venta_id','factura_id', 'pendiente','factura_venta') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $re, Authentication $usuario)
    {
        //dd($re->all());

        DB::beginTransaction();

        $venta_id = $re['venta_id'];
        $query = Venta::join('ventas__facturaventas', 'ventas__facturaventas.venta_id','=','ventas__ventas.id')
                      ->join('clientes__clientes', 'clientes__clientes.id','=','ventas__ventas.cliente_id')  
                      ->where('ventas__ventas.id',$venta_id)->get()->first();


        try
        {

            $hay_activo = Caja::where('activo', true)->first();

            if(!$hay_activo)
            {
                flash()->error('Deben haber una activa.');

                return redirect()->route('admin.caja.caja.index');
            }
            else
            {
                $re['caja_id'] = $hay_activo->id;

                $re['monto'] = intval( remove_dots( $re['monto'] ) );

                $re['fecha'] = date_to_server($re['fecha']);

                $venta = Venta::where('id', $re['venta_id'])->first();

                if( $re['monto']+$venta->suma_total_pagos > $venta->monto_total  )
                    $re['monto'] = $venta->monto_total - $venta->suma_total_pagos;

                $pago = Pagofacturacredito::create($re->all());

                $asiento = Asiento::create
                ([
  
                    'fecha' => $re['fecha'],
                    'observacion' => 'Pago de Venta a Crédito  |  Cliente:  '.$query->razon_social.'  |  Factura Nro:  '.$query->nro_factura,
                    'operacion' => 'Pago de Venta a Crédito',
                    'usuario_create_id' => $usuario->id(),
                    'entidad_type' => Pagofacturacredito::class,
                    'entidad_id' => $pago->id
                ]);

                AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('ventas.pagos.caja.debe')->id,
                    'debe' => $re['monto'],
                    'haber' => 0,
                    'observacion' => ''
                ]);

                AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('ventas.pagos.deudores_por_venta.haber')->id,
                    'debe' => 0,
                    'haber' => $re['monto'],
                    'observacion' => ''
                ]);

                $venta = Venta::where('id', $re['venta_id'])->first();

                $updated = Venta::where('id', $re['venta_id'])
                ->update(['total_pagado' => $venta->suma_total_pagos]);
            }


        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            //dd($e);
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('Pago Creado Correctamente'));

        return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);

        return redirect()->route('admin.ventas.facturaventa.edit',['id' => $re['factura_id'], 'pendiente' => $re['pendiente']]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pagofacturacredito $pagofacturacredito
     * @return Response
     */
    public function edit(Pagofacturacredito $pagofacturacredito, Request $request)
    {
        //dd($request->id);
        
        return view('pagofacturascredito::admin.pagofacturacreditos.edit', compact('pagofacturacredito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Pagofacturacredito $pagofacturacredito
     * @param  Request $request
     * @return Response
     */
    public function update(Pagofacturacredito $pagofacturacredito, Request $request)
    {
        $this->pagofacturacredito->update($pagofacturacredito, $request->all());

        flash()->success(trans('Pago Actualizado Correctamente'));

        return redirect()->route('admin.pagofacturascredito.pagofacturacredito.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pagofacturacredito $pagofacturacredito
     * @return Response
     */
    public function destroy(Pagofacturacredito $pagofacturacredito)
    {
        $venta = $pagofacturacredito->venta;

        DB::beginTransaction();

        try
        {
            foreach ($pagofacturacredito->asientos as $key => $asiento) 
            {
                foreach ($asiento->detalles as $key => $detalle) 
                    AsientoDetalle::where('id', $detalle->id)->delete();

                Asiento::where('id', $asiento->id)->delete();
            }

            $this->pagofacturacredito->destroy($pagofacturacredito);

            Venta::where('id', $venta->id)->update(['total_pagado' => $venta->total_pagado_pagos]);

        }
        catch (ValidationException $e)
        {
            DB::rollBack();

            flash()->error('Ocurrio un error al intentar eliminar el pago.');

            return redirect()->back();
        }

        DB::commit();

        flash()->success('Pago Eliminado Correctamente.');

        return redirect()->back();
    }
}
