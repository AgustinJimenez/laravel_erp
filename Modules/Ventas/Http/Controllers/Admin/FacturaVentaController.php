<?php namespace Modules\Ventas\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Ventas\Entities\FacturaVenta;
use Modules\Ventas\Repositories\FacturaVentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Ventas\Http\Requests\ConfigFacturaRequest;
use DB;
include( base_path().'/Modules/funciones_varias.php');
use Modules\Core\Contracts\Authentication;
//use Modules\Ventas\Http\Requests\FacturaVentaRequest;
use Modules\Ventas\Entities\ConfigFacturaVenta;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use Modules\Ventas\Entities\Venta;
use Modules\Ventas\Entities\DetalleVenta;
use Modules\Productos\Entities\Producto;
use Modules\Caja\Entities\Caja;
use Modules\Pagofacturascredito\Entities\Pagofacturacredito;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Clientes\Entities\Cliente;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Cuenta;

class FacturaVentaController extends AdminBaseController
{
    /**
     * @var FacturaVentaRepository
     */
    private $facturaventa;

    private $usuario;

    public function __construct(FacturaVentaRepository $facturaventa, Authentication $usuario)
    {
        parent::__construct();

        $this->facturaventa = $facturaventa;

        $this->usuario = $usuario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $re)
    {
        if($re['pendiente'])
            return view('ventas::admin.facturaventas.index-pendientes');
        if($re['isOtros'])
        {
            $isOtros = true;
            return view('ventas::admin.facturaventas.index', compact('isOtros'));
        }
        else
            return view('ventas::admin.facturaventas.index');  
    }

    public function index_ajax(Request $request)
    {
        //dd( $request['isOtros'] );
        
        $query = FacturaVenta::
                join('ventas__ventas','ventas__ventas.id','=','venta_id')
               ->join('clientes__clientes','clientes__clientes.id','=','ventas__ventas.cliente_id')
               ->join('users as user1','user1.id','=','ventas__facturaventas.usuario_sistema_id_create')
               ->leftjoin('users as user2','user2.id','=','ventas__facturaventas.usuario_sistema_id_edit');

            $query->whereNotIn('ventas__ventas.tipo',['otros']);

        $fecha_inicio = 'fecha_inicio';
        $fecha_fin = 'fecha_fin';
        $nro_seguimiento = 'nro_seguimiento';
        $razon_social = 'razon_social';
        $anulado = 'anulado';
        $pendiente = 'pendiente';

        if ($request->has($fecha_inicio) && trim($request->has($fecha_inicio) !== '') )
            $query->where('fecha', '>', date_to_server2($request[$fecha_inicio])->modify('-1 day')  );

        if ($request->has($fecha_fin) && trim($request->has($fecha_fin) !== '') )
            $query->where('fecha', '<', date_to_server2($request[$fecha_fin])  );

        if ($request->has($nro_seguimiento)  && trim($request->has($nro_seguimiento) !== '') )
            $query->where('nro_seguimiento', 'like', "%{$request[$nro_seguimiento]}%");

        if ($request->has($razon_social)  && trim($request->has($razon_social) !== '') )
            $query->where('clientes__clientes.razon_social', 'like', "%{$request[$razon_social]}%");

         if ($request->has('factura')  && trim($request->has('factura') !== '') )
            $query->where('ventas__facturaventas.nro_factura', 'like', "%{$request['factura']}%");

        if ($request->has('anulado')  && trim($request->has('anulado') !== '') )
            $query->where('ventas__ventas.anulado', $request->get('anulado'));

       if ( $request['pendiente'] )
       {
           $query->whereRaw('total_pagado < monto_total');
           $query->where('ventas__facturaventas.anulado', false);
       }
       else if($request['isOtros']==0)
           $query->whereRaw('total_pagado >= monto_total');

        $query->select
       (
            'ventas__facturaventas.id as id',
            'ventas__facturaventas.fecha as fecha',
            'ventas__facturaventas.nro_factura as nro_factura',
            'clientes__clientes.razon_social as razon_social',
            'ventas__facturaventas.anulado as anulado',
            'ventas__ventas.monto_total as monto_total',
            'ventas__ventas.total_pagado as total_pagado',
            DB::raw('CONCAT(user1.last_name," ",user1.first_name) as creado_por'),
            DB::raw('CONCAT(user2.last_name," ",user2.first_name) as editado_por')
        );
        
              

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) use ($request)
            {
                $base_path = "admin.ventas.facturaventa";
                $asEdit = $base_path.".edit";
                $asDestroy = $base_path.".destroy";
                if ( $request['pendiente'])
                    $editRoute = route($asEdit, ['id' => $tabla->id, 'pendiente=1']);
                else
                    $editRoute = route($asEdit, ['id' => $tabla->id]);

                $deleteRoute = route($asDestroy, [$tabla->id]);
                $buttons = "<div class='btn-group'>";
                if($tabla->anulado)
                    $buttons = $buttons."<a href='".$editRoute." ' class='btn btn-default btn-flat'><strong>DETALLES</strong></a>";
                else
                    $buttons = $buttons."<a href='".$editRoute." ' class='btn btn-default btn-flat'><strong>DETALLES</strong></a>";
                return $buttons;
            })
            ->editColumn('fecha', function($tabla)
            {
                return date_from_server($tabla->fecha);
            })
            ->editColumn('monto_total', function($tabla)
            {
                return thousands_separator_dots($tabla->monto_total);
            })
            ->editColumn('total_pagado', function($tabla)
            {
                return thousands_separator_dots($tabla->total_pagado);
            })
            ->editColumn('anulado', function($tabla)
            {
                if($tabla->anulado)
                    return "SI";
                else
                    return "NO";
            })
            ->make(true);

        return $object;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //$hoy = date('m/d/Y h:i:s a', time());

        $configs = ConfigFacturaVenta::get(['identificador', 'valor']);

        foreach ($configs as $config) 
        {
            $nro_factura[$config->identificador] = $config->valor;
        }

        $info_factura['nro_factura'] = $nro_factura['nro_factura_1'].' - '.$nro_factura['nro_factura_2'].' - '.$nro_factura['nro_factura_3'];
        
        date_default_timezone_set('America/Asuncion');

        $fecha = date('d/m/Y', time());

        $detalles = collect( array( (object)['id' => null, 'cantidad' => null,'descripcion' => null,'iva' => null, 'precio_unitario' => null] ) );

        return view('ventas::admin.facturaventas.create', compact('fecha', 'info_factura', 'forma_de_pago', 'detalles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $re, Authentication $usuario_sistema)
    {  
        DB::beginTransaction();

        try
        {
            $factura = FacturaVenta::create
            ([
                'venta_id' => isset($venta_id)?$venta_id:null,
                'razon_social' => $re['razon_social'],
                'direccion' => $re['direccion'],
                'ruc' => $re['ruc'],
                'telefono' => $re['telefono'],
                'forma_pago' => $re['forma_pago'],
                'fecha' => date_to_server( $re['fecha'] ),
                'nro_factura' => $re['nro_factura'],
                'monto_total' => remove_dots($re['monto_total']),
                'monto_total_letras' => $re['monto_total_letras'],
                'total_iva_5' => remove_dots($re['total_iva_5']),
                'total_iva_10' => remove_dots($re['total_iva_10']),
                'total_iva' => remove_dots($re['total_iva']),
                'observacion' => $re['observacion'],
                'anulado' => $re['anulado'],
                'usuario_sistema_id_create' => $usuario_sistema->id(),
                'cliente_id' => isset($cliente_id)?$cliente_id:null
            ]);

            ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');
        }
        catch (ValidationException $e)
        {
            DB::rollBack();

            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('ventas::facturaventas.title.facturaventas')]));

        return redirect()->route('admin.ventas.facturaventa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FacturaVenta $facturaventa
     * @return Response
     */
    public function edit(FacturaVenta $facturaventa, Request $re, Authentication $auth)
    {   
        $venta= Venta::where('id',$facturaventa->venta_id)->get()->first();
/*
        $permisos_usuario = DB::table('users')->where('id',$auth->id())->first()->permissions;

        $decode = json_decode($permisos_usuario);

        $array_permissions = (array) $decode;
        
        if( !isset($array_permissions['contabilidad.asientos.edit']) )
            $array_permissions['contabilidad.asientos.edit'] = false;

        if ($array_permissions['contabilidad.asientos.edit'] || ($array_permissions['contabilidad.asientos.edit']==true)) {

            $autorizar = true;
        }
        else
        {
            flash()->error('No tiene suficientes permisos.');

            return redirect()->back();
        }
*/

        $hay_activo = Caja::where('activo', true)->first();

        if(!$hay_activo)
        {
            flash()->error('Deben haber cajas activas.');

            return redirect()->route('admin.caja.caja.index');
        }
        else
        {
            $facturaventa = FacturaVenta::with('venta')->where('id', $facturaventa->id)->first();

            if($facturaventa->venta)
                $detalles = $facturaventa->venta->detalles;

            //dd( $detalles[0]->descripcion_producto );

            if($re['pendiente'])
            {
                $pendiente = true;

                return view('ventas::admin.facturaventas.edit', compact('facturaventa','detalles', 'pendiente', 'autorizar', 'venta'));
            }
            else
            {
                $pendiente = null;

                return view('ventas::admin.facturaventas.edit', compact('facturaventa','detalles', 'pendiente','autorizar','venta'));
            }
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FacturaVenta $facturaventa
     * @param  Request $request
     * @return Response
     */
    public function update(FacturaVenta $facturaventa, Request $re, Authentication $usuario_sistema)
    {
        date_default_timezone_set ( 'America/Asuncion' );
        $re['anulado'] = (int)$re['anulado'];

        $venta = $facturaventa->venta;

        $hay_activo = Caja::where('activo', true)->first();

        if(!$hay_activo)
        {
            flash()->error('Deben haber cajas activas.');

            return redirect()->route('admin.caja.caja.index');
        }
        else
        {
            if($re['anulado'] || $re['pendiente'])
            {
                DB::beginTransaction();

                try
                {
                    $venta_id = $facturaventa->venta_id;

                    if( $re['anulado'] )
                    {
                        FacturaVenta::where('id', $facturaventa->id)
                        ->update
                        ([
                            'anulado' => true,
                            'usuario_sistema_id_edit' => $usuario_sistema->id()
                        ]);

                        Venta::where('id', $venta->id)->update(['anulado' => true, 'usuario_sistema_id_edit' => $usuario_sistema->id()]);

                        Pagofacturacredito::create
                        ([
                            'venta_id' => $venta->id,
                            'caja_id' => $hay_activo->id,
                            'fecha' => get_actual_date_server(),
                            'forma_pago' => 'efectivo',
                            'monto' => ($venta->total_pagado*-1)
                        ]);

                        if(!$this->crear_contra_asientos( $facturaventa->venta ))
                        {
                            flash()->error('Error al intentar crear contraasientos.');

                            return redirect()->back();  
                        }
                        else
                            $contraasientos = true;

                        $detalles = DetalleVenta::where('venta_id', $venta_id)->get();

                        foreach ($detalles as $key => $detalle) 
                        {
                            if($detalle->producto_id)
                            {
                                $producto = Producto::where('id', $detalle->producto_id)->first();
                                
                                $stock_actual = $producto->stock;

                                $cantidad_vendida = $detalle->cantidad;

                                $stock_anterior = $stock_actual + $cantidad_vendida;

                                Producto::where('id', $detalle->producto_id)
                                ->update
                                ([
                                    'stock' => $stock_anterior
                                ]);
                            }   
                        }
                    }

                    if($re['pendiente'])
                    {
                        Venta::where('id',$venta_id)
                        ->update
                        ([
                            'total_pagado'=> remove_dots($re['total_pagado'])
                        ]);
                    }
                }
                catch (ValidationException $e)
                {
                    DB::rollBack();

                    return redirect()->back()->withErrors($e);
                }
                
                DB::commit();
            }

            if(isset($contraasientos))
                flash()->success('Factura anulada y contraasientos generados correctamente.');
            else
                flash()->success('Factura anulada correctamente.');



            if($re['pendiente'])
                return redirect()->route('admin.ventas.facturaventa.index',['pendiente=1']);
            else
                return redirect()->route('admin.ventas.facturaventa.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FacturaVenta $facturaventa
     * @return Response
     */
    public function destroy(FacturaVenta $facturaventa)
    {
        $hay_activo = Caja::where('activo', true)->first();

        if(!$hay_activo)
        {
            flash()->error('Deben haber cajas activas.');

            return redirect()->route('admin.caja.caja.index');
        }
        else
        {
            $this->facturaventa->destroy($facturaventa);

            flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('ventas::facturaventas.title.facturaventas')]));

            return redirect()->route('admin.ventas.facturaventa.index');
        }
    }

    public function edit_nro_factura()
    {
        $configs = ConfigFacturaVenta::get();

        if(count($configs)<1)
        {
            ConfigFacturaVenta::create([
            'id'=>'1',
            'identificador'=>'nro_factura_1',
            'nombre'=>'factura_inicio',
            'valor'=>'001'
            ]);

            ConfigFacturaVenta::create([
                'id'=>'2',
                'identificador'=>'nro_factura_2',
                'nombre'=>'factura_medio',
                'valor'=>'001'
                ]);

            ConfigFacturaVenta::create([
                'id'=>'3',
                'identificador'=>'nro_factura_3',
                'nombre'=>'factura_final',
                'valor'=>'001'
                ]);

            $configs = ConfigFacturaVenta::get();
        }

        return view('ventas::admin.ventas.edit_nro_factura', compact('configs'));
    }

    public function update_nro_factura(ConfigFacturaRequest $request)
    {

        $valores=$request->get('valor');

        $identificadores=$request->get('etiqueta');

        DB::beginTransaction();
        foreach ($identificadores as $key => $identificador) 
        {
            try
            {
                ConfigFacturaVenta::where('identificador',$identificador)->update(['valor' => $valores[$key]]);
            }
            catch (ValidationException $e)
            {
                DB::rollBack();

                flash()->error(trans('No se pudo actualizar.'.$e));
            }
        }

        DB::commit();

        flash()->success(trans('Actualizado Correctamente.'));

        return redirect()->route('admin.ventas.facturaventa.edit_nro_factura'); 
    }

    public function generar_facturas_vacias()
    {
        $configs = ConfigFacturaVenta::get(['identificador', 'valor']);

        $ult_nro_factura = FacturaVenta::orderBy('nro_factura','desc')->first()->nro_factura;

        foreach ($configs as $config) 
        {
            $nro_factura[$config->identificador] = $config->valor;
        }

        $nro_base = $nro_factura['nro_factura_1'].' - '.$nro_factura['nro_factura_2'].' - '.$nro_factura['nro_factura_3'];

        if($nro_base == $ult_nro_factura)
        {
            ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');

            $nro_factura['nro_factura_3']+=1;
        }

        $nro_base = $nro_factura['nro_factura_1'].' - '.$nro_factura['nro_factura_2'];

        $nro_incre = $nro_factura['nro_factura_3'];


        return view('ventas::admin.facturaventas.partials.generador-facturas-vacias', compact('nro_base', 'nro_incre'));
        
    }

    public function crear_facturas_vacias(Request $re, Authentication $usuario_sistema)
    {
        date_default_timezone_set('America/Asuncion');

        if($re['nro_fin'] > $re['nro_inicio']-1)
        {
            $dif = $re['nro_fin'] - $re['nro_inicio'];

            $configs = ConfigFacturaVenta::get(['identificador', 'valor']);

            foreach ($configs as $config) 
            {
                $nro_factura_actual[$config->identificador] = $config->valor;
            }

            $nro_base = $nro_factura_actual['nro_factura_1'].' - '.$nro_factura_actual['nro_factura_2'];

            DB::beginTransaction();

            try
            {
                for ($i=0; $i <= $dif; $i++) 
                { 
                    $nro_factura = $nro_base.' - '.str_pad(($re['nro_inicio']+ $i), 3, '0', STR_PAD_LEFT); 

                    FacturaVenta::
                    create
                    ([
                        'nro_factura' => $nro_factura,
                        'fecha' => date('Y-m-d', time()),
                        'anulado' => true,
                        'usuario_sistema_id_create' => $usuario_sistema->id()
                    ]);

                    ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');
                      
                }
            }
            catch (ValidationException $e)
            {

                DB::rollBack();
                return redirect()->back()->withErrors($e);
            }

            DB::commit();
        }
        else
        {
            flash()->error('Introduzca un valor final mayor o igual al valor inicial');

            return redirect()->back();
        }  

        flash()->success('Operacion Realizada Correctamente');
        return redirect()->route('admin.ventas.facturaventa.index');
        
    }

    function crear_contra_asientos($venta)
    {
        date_default_timezone_set('America/Asuncion');

        $asientos = $venta->asientos_all;

        $cliente = Cliente::where('id',$venta->cliente_id)->get()->first()->razon_social;

        $factura = FacturaVenta::where('venta_id',$venta->id)->get()->first()->nro_factura;

        try
        {

            foreach ($asientos as $key => $asiento) 
            {
                $contra_asiento = Asiento::create
                ([
                    'fecha' => get_actual_date_server(),
                    'operacion' => 'Anulacion ' . $asiento->operacion,
                    'observacion' => 'Anulacion de ' . $asiento->observacion ,
                    'usuario_create_id' => $this->usuario->id(),
                    'entidad_id' => $asiento->entidad_id,
                    'entidad_type' =>  $asiento->entidad_type
                ]);

                foreach ($asiento->detalles as $key2 => $detalle) 
                {
                    $contra_asiento_detalles[] = AsientoDetalle::create
                    ([
                        'asiento_id' => $contra_asiento->id,
                        'cuenta_id' => $detalle->cuenta_id,
                        'debe' => $detalle->haber,
                        'haber' => $detalle->debe
                    ]);
                }
            }
        }
        catch(Exception $e)
        {
            return false;
        }

        return true;
        
    }
}

