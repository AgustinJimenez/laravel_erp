<?php namespace Modules\Compras\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Compras\Entities\Compra;
use Modules\Compras\Repositories\CompraRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Contracts\Authentication;
use Modules\Compras\Http\Requests\CompraRequest;
use Modules\Compras\Entities\Detallecompra;
use Modules\Proveedores\Entities\Proveedor;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use DB,stdClass;
use Modules\Productos\Entities\Producto;
use Modules\Empleados\Entities\PagoEmpleado;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Compras\Entities\CompraPago;
use Modules\Caja\Entities\Caja;
include( base_path().'/Modules/funciones_varias.php');
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Cuenta;
use Response;

class CompraController extends AdminBaseController
{
    /**
     * @var CompraRepository
     */
    private $compra;

    private $auth;

    public function __construct(CompraRepository $compra, Authentication $auth)
    {
        parent::__construct();

        $this->compra = $compra;

        $this->auth=$auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('compras::admin.compras.index');
    }

    public function index_pendientes()
    {
        $pendiente = true;

        return view('compras::admin.compras.index', compact('pendiente') );
    }

    public function index_ajax(Request $request)
    {
        $query = Compra::join('proveedores__proveedors','proveedores__proveedors.id','=','proveedor_id')
                        ->orderBy('compras__compras.fecha','DESC')
                        ->select
                         ([
                            'compras__compras.id as id',
                            'compras__compras.tipo as tipo',
                            'compras__compras.nro_factura as nro_factura',
                            'proveedores__proveedors.razon_social',
                            'compras__compras.fecha as fecha',
                            'compras__compras.total_iva as total_iva',
                            'compras__compras.monto_total as monto_total',
                            'compras__compras.anulado as anulado',
                            'compras__compras.total_pagado as total_pagado',
                            'compras__compras.usuario_sistema_id as usuario_sistema_id'
                        ]);

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) use ($request)
            {
                $base_path = "admin.compras.compra.";

                $as_factura = $base_path."factura";

                $factura_route = route($as_factura, [$tabla->id]);

                $buttons = "<div class='btn-group'>";

                if( $tabla->tipo != "otro" or $request->user()->get_full_permisos->get('Permisos Especiales Compras')['Ver detalles de otras compras'] )
                {
                    $buttons=$buttons."<a href='".$factura_route." ' class='btn btn-default btn-flat'>
                                            <strong>DETALLES</strong>
                                        </a>";
                }
                $buttons=$buttons."</div>";

                return $buttons;
            })
            ->filter(function ($query) use ($request)
            {
                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
                {
                    $query->where('fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
                }

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
                {
                    $query->where('fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                }

                if ($request->has('nro_factura')  && trim($request->has('nro_factura') !== '') )
                {

                    $query->where('nro_factura', 'like', "%{$request->get('nro_factura')}%");

                }

                if ($request->has('proveedor')  && trim($request->has('proveedor') !== '') )
                {

                    $query->where('proveedores__proveedors.razon_social', 'like', "%{$request->get('proveedor')}%");

                }

                if ($request->has('usuario_sistema_id')  && trim($request->has('usuario_sistema_id') !== '') )
                {

                    $query->where('usuario_sistema_id', 'like', "%{$request->get('usuario_sistema_id')}%");
                }

                $query->where('compras__compras.anulado', $request['anulado']);

                if($request['pendiente'] == '1')
                    $query->whereRaw('compras__compras.total_pagado < compras__compras.monto_total');
                else
                    $query->whereRaw('compras__compras.total_pagado >= compras__compras.monto_total');


            })
            ->editColumn('total_iva', function($tabla)
            {
                return  number_format( $tabla->total_iva, 0, '', '.');
            })

            ->editColumn('monto_total', function($tabla)
            {
                return number_format( $tabla->monto_total, 0, '', '.');
            })

            ->editColumn('total_pagado', function($tabla)
            {
                return number_format( $tabla->total_pagado, 0, '', '.');
            })

            ->editColumn('fecha', function($tabla)
            {
                return date("d/m/Y", strtotime($tabla->fecha));
            })

            ->editColumn('anulado', function($tabla)
            {
                if($tabla->anulado == 0)
                {
                    return ("No");
                }
                else
                {
                    return ("Si");
                }
            })

            ->make( true );

        return $object;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $caja = Caja::where('activo', true)->first();

        if(!$caja)
        {

            flash()->error('Para crear algun tipo de Compra, debe existir una Caja Activa.');

            return redirect()->route('admin.caja.caja.index');
        }

        $isProducto = false;
        $isCristal = false;
        $isServicio = false;
        $isOtro = false;

        $haber_contado = \CuentasFijas::get('compra.caja');
        $haber_credito = \CuentasFijas::get('compra.proveedores');


        if($request->get('isProducto'))
        {
            $isProducto = true;
            $debe = \CuentasFijas::get('compra.costo_mercaderia_grabadas_iva');

        }
        else if($request->get('isCristal'))
        {
            $isCristal = true;
            $debe = \CuentasFijas::get('compra.costo_mercaderia_grabadas_iva');
        }
        else if($request->get('isServicio'))
        {
            $isServicio = true;
            $debe = \CuentasFijas::get('compra.pago_servicios');
        }
        else if($request->get('isOtro'))
        {
            $isOtro = true;
            $debe = \CuentasFijas::get('compra.insumos');
        }
        date_default_timezone_set('America/Asuncion');

        $fecha_hoy = date('d/m/Y', time());

        return view('compras::admin.compras.create', compact('comprasProductos','isProducto','isServicio','isCristal','isOtro','fecha_hoy', 'nro_factura','haber', 'debe', 'haber_contado', 'haber_credito'));
    }

    public function seleccion()
    {
        return view('compras::admin.compras.seleccion');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CompraRequest $request, Authentication $usuario)
    {
        //dd( $request->all() );

        if( !$caja = Caja::where('activo', true)->first() )
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        if( $request->isProducto )
            $tipo = 'producto';
        else if($request->isServicio)
            $tipo = 'servicio';
        else if($request->isCristal)
            $tipo = 'cristal';
        else if($request->isOtro)
            $tipo = 'otro';
        /*
            $nro_factura = $request->get('nro_factura');
        */

        $timbrado = $request->get('timbrado');

        $proveedor_id = $request->get('proveedor_id');

        $razon_social = $request->get('razon_social');

        $ruc_proveedor = $request->get('ruc_proveedor');

        $fecha = Carbon::createFromFormat('d/m/Y', $request->get('fecha') );

        $tipo_factura = $request->get('tipo_factura');

        $monto_total = str_replace('.', '', $request->get('monto_total') );

        $monto_total_letras = $request->get('monto_total_letras');

        $total_iva_5 = $request->get('total_iva_5');

        $total_iva_10 = $request->get('total_iva_10');

        $total_iva = str_replace('.', '', $request->get('total_iva') );

        $observacion = $request->get('observacion');

        $total_pagado = str_replace('.', '', $request->get('total_pagado') );

        $comprobante = $request->get('comprobante');

        $nro_factura = $request->get('nro_factura');

        $moneda = $request->get('moneda');

        $cambio = $request->get('cambio');

        $pagado_por = $request->get('pagado_por');

        $comentario_pagado_por = $request->get('comentario_pagado_por');

        $usuario_sistema_id = $this->auth->id();

        $debe_id = $request['deber_id'];

        $haber_id = $request['haber_id'];
        //dd($request['cantidad']);

/*----------------------------------------------------------------------------*/

        $iva_10 = 0;

        $iva_5 = 0;

        $grabado_excenta = 0;

        $total_item_con_iva_10 = 0;

        $total_item_con_iva_5 = 0;

        $grabado_5 = 0;

        $grabado_10 = 0;

        $cambio_int = intval(str_replace('.', '', $cambio));

        $cantidad_array = collect($request['cantidad']);
        $cantidad_array->transform(function ($item, $key)
        {
            $item = str_replace('.', '', $item);
            $item = str_replace(",",".", $item);
            return (double)$item;
        });
        $request['cantidad'] = $cantidad_array->toArray();

        for ($i=0; $i < count($request['cantidad']) ; $i++)
        {

            $precio_unitario = $this->formatFloatForSave($request['precio_unitario'][$i]);

            $cantidad = $request['cantidad'][$i];

            if($request['iva'][$i] == '11')
            {
                $iva_10 += ($precio_unitario*$cantidad*$cambio_int)/11;

                $total_item_con_iva_10 += $precio_unitario*$cantidad*$cambio_int;
            }
            else if($request['iva'][$i] == '21')
            {
                $iva_5 += ($precio_unitario*$cantidad*$cambio_int)/21;

                $total_item_con_iva_5 += $precio_unitario*$cantidad*$cambio_int;
            }
            else
            {
                $grabado_excenta += $precio_unitario*$cantidad*$cambio_int;
            }
        }

        $grabado_excenta = intval($grabado_excenta);
        $grabado_5 = intval($grabado_5);
        $grabado_10 = intval($grabado_10);
        $iva_10 = intval($iva_10);
        $iva_5 = intval($iva_5);

        $grabado_10 = $total_item_con_iva_10 - $iva_10;

        $grabado_5 = $total_item_con_iva_5 - $iva_5;

        $total_suma = $grabado_excenta + $grabado_5 + $grabado_10 + $iva_10 + $iva_5;


        //dd('EXCENTA='.$grabado_excenta.' GRABADO 5% ='.$grabado_5.' GRABADO 10% ='.$grabado_10.' IVA 5%='.$total_iva_5.' IVA 10%='.$total_iva_10.' TOTAL='.$request->monto_total.' TOTAL DE SUMA='.$total_suma);


/*---------------------------details------------------------------------------*/
        $descripcion = $request->get('descripcion');

        $producto_id = $request->get('producto_id');

        $cantidad = $request->get('cantidad');

        $iva = $request->get('iva');

        $precio_unitario = $request->get('precio_unitario');

        $sub_total = $request->get('sub_total');

        DB::beginTransaction();
        //dd($total_iva_10);
        try
        {
            //dd($total_iva );

            if($total_pagado > $monto_total)
                $total_pagado = $monto_total;

            $compra = Compra::create
            ([
                'tipo' => $tipo,
                'proveedor_id' => $proveedor_id,
                'razon_social' => $razon_social,
                'ruc_proveedor' => $ruc_proveedor,
                'fecha' => $fecha,
                'tipo_factura' => $tipo_factura,
                'timbrado' => $timbrado,
                'nro_factura' => $nro_factura,
                'monto_total' => $monto_total,
                'monto_total_letras' => $monto_total_letras,
                'grabado_excenta' => $grabado_excenta,
                'grabado_5' => $grabado_5,
                'grabado_10' => $grabado_10,
                'total_iva_5' => $iva_5,
                'total_iva_10' => $iva_10,
                'total_iva' => $total_iva,
                'observacion' => $observacion,
                'total_pagado' => $total_pagado,
                'comprobante' => $comprobante,
                'moneda' => $moneda,
                'cambio' => $cambio,
                'pagado_por' => $pagado_por,
                'comentario_pagado_por' => $comentario_pagado_por,
                'usuario_sistema_id' => $usuario_sistema_id
            ]);

            if( $total_pagado > 0)
            {

                $pago = CompraPago::create
                ([
                    'compra_id' => $compra->id,
                    'caja_id' => $caja->id,
                    'fecha' => $fecha,
                    'forma_pago' => $request['forma_pago'],
                    'monto' => $total_pagado
                ]);


            }


            //

            /*--GENERAR ASIENTOS INICIO--*/

            // if($request['tipo_factura'] == 'contado')
            // {
            //     /*--HEADER--*/

            if($tipo_factura != 'credito')
            {
                if ($tipo == 'producto')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Contado de Productos  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Contado de Productos',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'cristal')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Contado de Cristal  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Contado de Cristal',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'servicio')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Contado de Servicio  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Contado de Servicio',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'otro')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Contado de Otro  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Contado de Otro',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }

            }

            else
            {
                if ($tipo == 'producto')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Credito de Productos  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Credito de Productos',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'cristal')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Credito de Cristal  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Credito de Cristal',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'servicio')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Credito de Servicio  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Credito de Servicio',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }
                if ($tipo == 'otro')
                {
                    $asiento = Asiento::create
                    ([
                        'fecha' => $fecha,
                        'observacion' => 'Compra Credito de Otro  |  Proveedor: '.$compra->proveedor->razon_social.'  |  Factura Nro: '.$request['nro_factura'],
                        'operacion' => 'Compra Credito de Otro',
                        'usuario_create_id' => $usuario_sistema_id,
                        'entidad_type' => Compra::class,
                        'entidad_id' => $compra->id

                    ]);
                }

            }




                /*--DETAILS--*/
                //Costos de Mercaderias
                if($total_iva > 0)
                {

                    //Costos de Mercaderias
                    AsientoDetalle::create
                    ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => $debe_id, //ya trae el id por defecto para venta(credito,contado) o seleccionado por usuario
                    'debe' => $monto_total-$total_iva,
                    'haber' => 0,
                    'observacion' => ''
                    ]);

                    //IVA - Credito Fiscal
                    AsientoDetalle::create
                    ([
                        'asiento_id' => $asiento->id,
                        'cuenta_id' => \CuentasFijas::get('compra.iva_credito_fiscal.debe')->id,
                        'debe' => $total_iva,//
                        'haber' => 0,
                        'observacion' => ''
                    ]);
                }
                else
                {

                    AsientoDetalle::create
                    ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => $debe_id,////ya trae el id por defecto para venta(credito,contado) o seleccionado por usuario
                    'debe' => $monto_total-$total_iva,
                    'haber' => 0,
                    'observacion' => ''
                    ]);

                }

                //Caja
                AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => $haber_id,//Caja
                    'debe' => 0,
                    'haber' => $monto_total,
                    'observacion' => ''
                ]);

            for($i = 0; $i < count($cantidad); $i++)
            {

                if ( $iva[$i]=='11' )
                {
                    $iva[$i] = '10';
                }
                else if( $iva[$i]=='21' )
                {
                    $iva[$i] = '5';
                }
                else
                {
                    $iva[$i] = 'excenta';
                }

                if($request->get('isProducto') == '1')
                {
                    if(!$producto_id[$i])
                    {
                        $producto_id[$i] = null;
                    }

                    $stock_producto = Producto::where('id',$producto_id[$i])->select('stock')
                        ->first()->stock;

                    $precio_compra_producto = Producto::where('id',$producto_id[$i])->select('precio_compra')
                        ->first()->precio_compra;


                    //dd(($stock_producto*$precio_compra_producto));
                    $nuevo_precio_compra_promedio = number_format( (($stock_producto*$precio_compra_producto)+($cantidad[$i]*str_replace('.', '', $this->formatFloatForSave($precio_unitario[$i]))) )/($stock_producto+$cantidad[$i]), 3, '.', '');

                    DB::table('productos__productos')
                        ->where('id',$producto_id[$i])
                        ->update
                        ([
                            'stock' => ($stock_producto+$cantidad[$i] ),
                            'precio_compra_promedio' => $nuevo_precio_compra_promedio,
                        ]);
                }


                Detallecompra::create
                ([
                    'compra_id' => $compra->id ,
                    'descripcion' => $descripcion[$i] ,
                    'producto_id' => $producto_id[$i] ,
                    'cantidad' => $cantidad[$i],
                    'iva' => $iva[$i],
                    'precio_unitario' => $this->formatFloatForSave($precio_unitario[$i]) ,
                    'precio_total' => $this->formatFloatForSave($sub_total[$i])
                ]);


            }

        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            //dd($e);
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('compras::compras.title.compras')]));
/*
        if( isset($asiento) )
            return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);
*/
        if($compra->total_pagado<$compra->monto_total)
            return redirect()->route('admin.compras.compra.index_pendientes');
        else
            return redirect()->route('admin.compras.compra.index');
    }

    public function factura(Compra $compra, Authentication $auth)
    {
        $fecha = $compra->fecha_compra;

        $compra->fecha = $compra->fecha_format;

        return view('compras::admin.facturas.factura', compact('compra','fecha'));
    }



    public function factura_update(Compra $compra, Request $re)
    {

        if( !$caja = Caja::where('activo', true)->first() )
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $re['anulado'] = intval($re['anulado']);

        DB::beginTransaction();

        try
        {
            if($re['anulado'])
            {
                $pago = CompraPago::create(['compra_id' => $compra->id, 'caja_id' => $caja->id, 'fecha' => get_actual_date_server(), 'forma_pago' => 'efectivo', 'monto' => ($compra->suma_total_pagos)*-1]);

                Compra::where('id', $compra->id)->update(['anulado' => $re['anulado'] ]);

                $this->crear_contra_asientos($compra);

                $detalles = $compra->detalles;

                foreach ($detalles as $key => $detalle)
                {
                    if($detalle->producto_id)
                    {
                        $producto_id = $detalle->producto_id;

                        $stock_producto = DB::table('productos__productos')
                                ->where('id',$producto_id)
                                ->select('stock')
                                ->first()
                                ->stock;

                        $precio_compra_promedio_producto = Producto::where('id', $producto_id)
                                                            ->select('precio_compra_promedio')
                                                            ->first()
                                                            ->precio_compra_promedio;

                        $stock_menos_cantidad_comprada = $stock_producto-$detalle->cantidad;
                        if( $stock_menos_cantidad_comprada <= 0 )
                            $old_precio_compra_promedio = 0;
                        else
                            $old_precio_compra_promedio = ( ($stock_producto*$precio_compra_promedio_producto)-($detalle->cantidad*$detalle->precio_unitario) )/($stock_menos_cantidad_comprada);

                        $cantidad_detalle_DB = $detalle->cantidad;
                        $stock_producto_reset = $stock_producto - $cantidad_detalle_DB;
                        DB::table('productos__productos')
                            ->where('id',$producto_id)
                            ->update(['stock' =>  $stock_producto_reset, 'precio_compra_promedio' => $old_precio_compra_promedio]);
                    }
                }

            }

        }
        catch (ValidationException $e)
        {
            DB::rollBack();

            flash()->error('Error al intentar anular factura.');

            return redirect()->route('admin.compras.compra.factura', $compra->id);
        }

        DB::commit();

        flash()->success('Guardado Correctamente.');

        if(isset($asiento) )
        {
            flash()->success('Factura Anulada Correctamente.');

            return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);
        }

        return redirect()->route('admin.compras.compra.index');
    }


    public function pago_create(Compra $compra)
    {
        if( !$caja = Caja::where('activo', true)->first() )
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $fecha = (object)['fecha' => get_actual_date()];

        $deber = \CuentasFijas::get('compra.pago.proveedores');

        $haber = \CuentasFijas::get('compra.pago.caja');

        return view('compras::admin.pagos.create', compact('compra', 'caja', 'fecha', 'deber', 'haber') );
    }

    public function pago_store(Request $re)
    {
        if( !$caja = Caja::where('activo', true)->first() )
        {
            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $re['fecha'] = date_to_server($re['fecha']);

        $re['monto'] = remove_dots($re['monto']);

        $re['caja_id'] =  $caja->id;

        $compra = Compra::where('id', $re['compra_id'])->first();

        // dd($compra->proveedor_id);
        $proveedor = Proveedor::where('id', $compra->proveedor_id)->get()->first()->razon_social;

        if( $re['monto']+$compra->suma_total_pagos > $compra->monto_total  )
                $re['monto'] = $compra->monto_total - $compra->suma_total_pagos;

        $pago = CompraPago::create($re->all());

        $asiento_pago = Asiento::create
        ([
            'fecha' => $re['fecha'],
            'observacion' => 'Pago de Compra a Credito  |  Proveedor: '.$proveedor.'  | Factura Nro: '.$compra->nro_factura,
            'operacion' => 'Pago de Compra a Credito',
            'usuario_create_id' => $this->auth->id(),
            'entidad_type' => CompraPago::class,
            'entidad_id' => $pago->id
        ]);


        AsientoDetalle::create
        ([
            'asiento_id' => $asiento_pago->id,
            'cuenta_id' => $re['haber_id'],
            'debe' => 0,
            'haber' => $re['monto'],
            'observacion' => ''
        ]);

        AsientoDetalle::create
        ([
            'asiento_id' => $asiento_pago->id,
            'cuenta_id' => $re['deber_id'],//Proveedores Locales
            'debe' => $re['monto'],
            'haber' => 0,
            'observacion' => ''
        ]);

        Compra::where('id', $re['compra_id'])
            ->update(['total_pagado' => ($compra->suma_total_pagos+$re['monto']) ]);


        return redirect()->route('admin.compras.compra.factura', $compra->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Compra $compra
     * @return Response
     */
    public function edit(Compra $compra)
    {
        //dd($compra->all());

        if( !$caja = Caja::where('activo', true)->first() )
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $isProducto = 0;
        $isServicio = 0;
        $isCristal = 0;
        $isOtro = 0;

        $detalles = Detallecompra::where('compra_id', $compra->id)->get();

        //dd( $detalles_compras );

        if($compra->tipo == 'producto')
        {
            $isProducto = 1;

        }
        else if($compra->tipo == 'servicio')
        {
            $isServicio = 1;
        }
        else if($compra->tipo == 'cristal')
        {
            $isCristal = 1;
        }
        else
        {
            $isOtro = 1;
        }

        $compra->fecha = $compra->fecha_format;

        return view('compras::admin.compras.edit', compact('compra','isProducto','isServicio','isCristal','isOtro','detalles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Compra $compra
     * @param  Request $request
     * @return Response
     */
    public function update(Compra $compra, CompraRequest $request)
    {
        //dd( $request->all() );
        if( !$caja = Caja::where('activo', true)->first() )
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $proveedor_id = $request->get('proveedor_id');

        $razon_social = $request->get('razon_social');

        $ruc_proveedor = $request->get('ruc_proveedor');

        $fecha = $request->get('fecha');

        $tipo_factura = $request->get('tipo_factura');

        $monto_total = $request->get('monto_total');

        $monto_total_letras = $request->get('monto_total_letras');

        $total_iva_5 = $request->get('total_iva_5');

        $total_iva_10 = $request->get('total_iva_10');

        $total_iva = $request->get('total_iva');

        $observacion = $request->get('observacion');

        $total_pagado = $request->get('total_pagado');

        $comprobante = $request->get('comprobante');

        $moneda = $request->get('moneda');

        $cambio = $request->get('cambio');

        $pagado_por = $request->get('pagado_por');

        $comentario_pagado_por = $request->get('comentario_pagado_por');

        $usuario_sistema_id = $this->auth->id();
/*---------------------------details------------------------------------------*/
        $eliminar = $request->get('eliminar');

        $detalle_id = $request->get('detalle_id');

        $borrar = $request->get('borrar');

        $descripcion = $request->get('descripcion');

        $producto_id = $request->get('producto_id');

        $cantidad = $request->get('cantidad');

        $iva = $request->get('iva');

        $precio_unitario = $request->get('precio_unitario');

        $sub_total = $request->get('sub_total');

        DB::beginTransaction();

        try
        {
            //dd( Compra::where('id',$compra->id)->first() );

            Compra::where('id',$compra->id)->update
            ([
                'proveedor_id' => $proveedor_id,
                'razon_social' => $razon_social,
                'ruc_proveedor' => $ruc_proveedor,
                'fecha' => Carbon::createFromFormat('d/m/Y', $fecha),
                'tipo_factura' => $tipo_factura,
                'monto_total' => intval(str_replace('.', '', $monto_total)),
                'monto_total_letras' => $monto_total_letras,
                'total_iva_5' => intval(str_replace('.', '', $total_iva_5)),
                'total_iva_10' => intval(str_replace('.', '', $total_iva_10)),
                'total_iva' => intval(str_replace('.', '', $total_iva )),
                'observacion' => $observacion,
                'total_pagado' => intval(str_replace('.', '', $total_pagado)),
                'comprobante' => $comprobante,
                'moneda' => $moneda,
                'cambio' => $cambio,
                'pagado_por' => $pagado_por,
                'comentario_pagado_por' => $comentario_pagado_por,
                'total_pagado' => str_replace('.', '', $total_pagado),
                'usuario_sistema_id_edit' => $usuario_sistema_id
            ]);




            for($i = 0; $i < count($cantidad); $i++)
            {
                if( $i<count($eliminar) && $eliminar[$i] == 'si')
                {
                    if($producto_id[$i])
                    {
                        $stock_producto = DB::table('productos__productos')
                                ->where('id',$producto_id[$i])->select('stock')
                                ->first()->stock;

                        $cantidad_detalle_DB = Detallecompra::where('id', $detalle_id[$i])->first()->cantidad;

                        $stock_producto_reset = $stock_producto - $cantidad_detalle_DB ;


                        DB::table('productos__productos')
                            ->where('id',$producto_id[$i])
                            ->update(['stock' =>  $stock_producto_reset ]);
                    }

                    Detallecompra::where('id', $detalle_id[$i])->delete();
                }
                else
                {
                    $detalle_actual = Detallecompra::where('id', $detalle_id[$i])->first();

                    if ( $iva[$i]=='11' )
                    {
                        $iva[$i] = '10';
                    }
                    else if( $iva[$i]=='21' )
                    {
                        $iva[$i] = '5';
                    }
                    else
                    {
                        $iva[$i] = 'excenta';
                    }

                    if($request->get('isProducto') == '1')
                    {
                        if(!$producto_id[$i])
                        {
                            $producto_id[$i] = null;
                        }

                        if( $detalle_actual && $producto_id[$i] == $detalle_actual->producto_id )
                        {//si el producto del detalle actual es el mismo al que hay que actualizar

                            $stock_producto_actual = DB::table('productos__productos')->where('id',$producto_id[$i])->first()->stock;//

                            $detalle_cantidad_actual = $detalle_actual->cantidad;

                            $stock_old = $stock_producto_actual - $detalle_cantidad_actual;

                            $stock_updated = $stock_old + $cantidad[$i];

                            DB::table('productos__productos')->where('id',$producto_id[$i])->update(['stock' => $stock_updated ]);
                        }
                        else if($detalle_actual  && $producto_id[$i] != $detalle_actual->producto_id )//si se cambio de producto hay que restaurar el anterior
                        {
                            $producto_old_id = $detalle_actual->producto_id;//ID PRODUCTO ANTERIOR

                            $stock_old = DB::table('productos__productos')->where('id',$producto_old_id)->first()->stock;//STOCK PRODUCTO ANTERIOR

                            $cantidad_actual = $detalle_actual->cantidad;//CANTIDAD AGREGADA A EL ANTERIOR PRODUCTO

                            $stock_restaurado = $stock_old - $cantidad_actual;

                            DB::table('productos__productos')
                            ->where('id',$producto_old_id)
                            ->update(['stock' => $stock_restaurado ]);

                            $stock_producto_actual = DB::table('productos__productos')//stock producto nuevo
                                ->where('id',$producto_id[$i])->select('stock')
                                ->first()->stock;

                            $stock_updated = $stock_producto_actual + $cantidad[$i];

                            DB::table('productos__productos')
                                ->where('id',$producto_id[$i])
                                ->update(['stock' => $stock_updated ]);
                        }
                    }
                    if( $detalle_id[$i]!='' )
                    {
                        Detallecompra::where('id',$detalle_id[$i])->update
                        ([
                            'compra_id' => $compra->id ,
                            'descripcion' => $descripcion[$i] ,
                            'producto_id' => $producto_id[$i] ,
                            'cantidad' => str_replace('.', '', $cantidad[$i] ) ,
                            'iva' => $iva[$i],
                            'precio_unitario' => str_replace('.', '', $precio_unitario[$i]) ,
                            'precio_total' => str_replace('.', '', $sub_total[$i])
                        ]);
                    }
                    else
                    {
                        Detallecompra::create
                        ([
                            'compra_id' => $compra->id ,
                            'descripcion' => $descripcion[$i] ,
                            'producto_id' => $producto_id[$i] ,
                            'cantidad' => str_replace('.', '', $cantidad[$i] ) ,
                            'iva' => $iva[$i],
                            'precio_unitario' => str_replace('.', '', $precio_unitario[$i]) ,
                            'precio_total' => str_replace('.', '', $sub_total[$i])
                        ]);
                    }

                }




            }

        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            //dd($e);
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('compras::compras.title.compras')]));

        return redirect()->route('admin.compras.compra.index');
    }

    public function edit_config_factura()
    {

    }

    public function update_config_factura(Request $re)
    {

    }

    //Utilizado para estructurar reporte de Gastos
    public function reporte_gastos_performance()
    {
        $opciones_categoria = ['Producto', 'Cristal', 'Servicio', 'Otro', 'Salario'];

        for ($i=0; $i <count($opciones_categoria) ; $i++)
        {
            $categorias[$opciones_categoria[$i]] = $opciones_categoria[$i];
        }

        return view('compras::admin.compras.reporte_gastos_performance', compact('categorias'));
    }


    public function reporte_gastos(Request $request)
    {
        $actual_date = (object)['fecha_fin' => (new Carbon('now'))->format('d/m/Y')];
        $first_day_month = (object)['fecha_inicio' => (new Carbon('first day of this month'))->format('d/m/Y')];
        if ($request['categoria']==='Salario')
        {
            $categorias= $request['categoria'];

            return view('compras::admin.compras.reporte_gastos_salario', compact('categorias', 'actual_date', 'first_day_month'));
        }
        else
        {
            $categorias= $request['categoria'];
            return view('compras::admin.compras.reporte_gastos', compact('categorias', 'actual_date', 'first_day_month'));
        }
    }

    public function query_reporte(Request $request)
    {
        //dd($request->all());
        $categoria= $request['categoria'];

        if ($categoria != 'Salario')
        {

            if ( $request['download_xls'] == 'yes' )
            {
                $request['fecha_inicio'] = $request['fecha_inicio2'];

                $request['fecha_fin'] = $request['fecha_fin2'];
            };

            $query = Compra::join('proveedores__proveedors', 'proveedores__proveedors.id','=','compras__compras.proveedor_id')
            ->select('compras__compras.*','proveedores__proveedors.razon_social as razon_social')->where('tipo',$categoria);

            if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
            {
                $query->where('fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
            }

            if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
            {
                $query->where('fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
            }

            if($request['download_xls'] == 'yes')
            {
                $query->select
                (
                   'nro_factura as Nro_de_Factura',
                   'proveedores__proveedors.razon_social as Proveedor',
                   'fecha as Fecha_de_Compra',
                   'monto_total as Monto_Total',
                   'total_pagado as Total_Pagado'
                );
            }
        }
        else
        {
           if ( $request['download_xls'] == 'yes' )
            {
                $request['fecha_inicio'] = $request['fecha_inicio2'];

                $request['fecha_fin'] = $request['fecha_fin2'];
            };

            $query = PagoEmpleado::join('empleados__empleados','empleados__empleados.id','=','empleados__pagoempleados.empleado_id')
                ->where('activo',true)
            ->select
            ([
                'empleados__empleados.nombre as nombre',
                'empleados__empleados.apellido as apellido',
                'empleados__empleados.salario as salario',
                'empleados__pagoempleados.extra as extra'
                ]);

            if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
            {
                $query->where('fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
            }

            if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
            {
                $query->where('fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
            }

            if($request['download_xls'] == 'yes')
            {
                $query->select
                ('*');
            }
        }

        //dd($query->get()->all());
        return $query;

    }

    public function reporte_gastos_ajax(Request $request)
    {
        //dd($request->all());
        $categoria = $request['categoria'];

        if ($categoria != 'Salario')
        {
            $query = $this->query_reporte($request);

            $query -> select('*')->where('tipo','=',$categoria);

            $sum_total_pagado = number_format( $query->sum('total_pagado'), 0, '', '.');

            $sum_monto_total = number_format( $query->sum('monto_total'), 0, '', '.');

            $object = Datatables::of( $query )

                ->editColumn('total_pagado', function($tabla) use ($query)
                {
                    $sum_total_pagado = number_format( $query->sum('total_pagado'), 0, '', '.');

                    return number_format($tabla->total_pagado, 0, '', '.');
                })
                ->editColumn('monto_total', function($tabla) use ($query)
                {
                    $sum_monto_total = number_format( $query->sum('monto_total'), 0, '', '.');

                    return number_format($tabla->monto_total, 0, '', '.');
                })
                ->editColumn('fecha', function($tabla) use ($query)
                {
                    return $tabla->format("fecha","date");
                })
                ->make(true);


            $data = $object->getData(true);

            $data['sum_total_pagado'] = $sum_total_pagado;

            $data['sum_monto_total'] = $sum_monto_total;

            //dd($data['sum_total_pagado']);

            //dd(response()->json($data));
        }
        else
        {
            $query = $this->query_reporte($request);

            $query -> select('*');

            $sum_monto_total = 0;
            $sum_total_pagado_salarios = 0;
            $sum_total_pagado_ips = 0;

            $object = Datatables::of( $query )

                ->editColumn('salario', function($tabla) use ($query)
                {
                    $salario = $tabla->salario;

                    $salario_neto = number_format( $salario*0.91 , 0, '', '.');

                    if ($tabla->ips==true)
                    {

                        return $salario_neto;
                    }
                    else
                    {
                        return number_format( $salario , 0, '', '.');
                    }

                })

                ->editColumn('monto_ips', function($tabla) use ($query)
                {

                        $monto_ips = $tabla->monto_ips;

                        return number_format( $monto_ips, 0, '', '.');;
                })

                ->editColumn('extra', function($tabla) use ($query)
                {

                    $extra = $tabla->extra;

                   return number_format( $extra, 0, '', '.');

                })

                ->editColumn('total', function($tabla) use ($query)
                {
                    $sum_monto_total = 0;

                    if($tabla->ips==true)
                    {

                        //$salario = intval(str_replace('.', '', $tabla->salario));

                        $salario_neto = intval($tabla->salario*0.91);

                        $extra = intval(str_replace('.', '', $tabla->extra));

                        $monto_ips = intval($tabla->salario*0.165);

                        $monto_total = $extra + $monto_ips+ $salario_neto ;


                        return number_format($monto_total, 0, '', '.');
                    }

                    else
                    {
                        $salario = intval(str_replace('.', '', $tabla->salario));

                        $extra = intval($tabla->extra);

                        $monto_total = $salario + $extra;

                        return number_format($monto_total, 0, '', '.');
                    }

                })

                ->addColumn('total_pagado_salarios', function($tabla) use ($query)
                {

                    $sum_total_pagado_salarios=0;

                    $salario = $tabla->salario;

                    if ($tabla->ips==true)
                    {
                        $salario_neto= $salario*0.91;

                        $sum_total_pagado_salarios+= $salario;
                    }
                    else
                    {

                        $sum_total_pagado_salarios+= $salario;
                    }

                    return number_format( $sum_total_pagado_salarios, 0, '', '.');;
                })

                ->addColumn('total_pagado_ips', function($tabla) use ($query)
                {

                    $sum_total_pagado_ips=0;

                    $salario = $tabla->salario;

                    if ($tabla->ips==true)
                    {
                        $ips= $salario*0.165;

                        $sum_total_pagado_ips+= $ips;
                    }
                    else
                    {
                        $sum_total_pagado_ips+=0;
                    }

                    return number_format( $sum_total_pagado_ips, 0, '', '.');;
                })

                ->make(true);


            $data = $object->getData(true);

            $datos = $object->getData('data');

            $array_total = $datos['data'];


            //dd($array_total);
            foreach ($array_total as $key => $value)
            {

                $total= $value['total'];

                $total_salario= $value['total_pagado_salarios'];

                $total_ips= $value['total_pagado_ips'];

                $aux_total = intval(str_replace('.', '', $total));

                $aux_salario = intval(str_replace('.', '', $total_salario));

                $aux_ips = intval(str_replace('.', '',  $total_ips));

                $sum_monto_total+= $aux_total;

                $sum_total_pagado_salarios+= $aux_salario;

                $sum_total_pagado_ips+= $aux_ips;
            }

            $data['sum_total_pagado'] = number_format($sum_monto_total, 0, '', '.');
            $data['sum_total_pagado_salarios'] = number_format($sum_total_pagado_salarios, 0, '', '.');
            $data['sum_total_pagado_ips'] = number_format($sum_total_pagado_ips, 0, '', '.');
        }

        return response()->json($data);

    }



    // public function categorias_reporte_gastos_ajax(Request $request)
    // {
    //     //dd($request->all());
    //     $query = $this->query_reporte_categoria($request);

    //     $query -> select('*');

    //     $sum_total_pagado = number_format( $query->sum('total_pagado'), 0, '', '.');

    //     $sum_monto_total = number_format( $query->sum('monto_total'), 0, '', '.');

    //     $object = Datatables::of( $query )

    //         ->editColumn('total_pagado', function($tabla) use ($query)
    //         {
    //             $sum_total_pagado = number_format( $query->sum('total_pagado'), 0, '', '.');

    //             return number_format($tabla->total_pagado, 0, '', '.');
    //         })
    //         ->editColumn('monto_total', function($tabla) use ($query)
    //         {
    //             $sum_monto_total = number_format( $query->sum('monto_total'), 0, '', '.');

    //             return number_format($tabla->monto_total, 0, '', '.');
    //         })
    //         ->editColumn('fecha', function($tabla) use ($query)
    //         {
    //             return $tabla->fecha;
    //         })
    //         ->make(true);


    //     $data = $object->getData(true);

    //     $data['sum_total_pagado'] = $sum_total_pagado;

    //     $data['sum_monto_total'] = $sum_monto_total;

    //     //dd(response()->json($data));

    //     return response()->json($data);

    // }

    public function reporte_xls(Request $request)
    {
        //dd($request['categoria']);
        $query = $this->query_reporte($request);

        Excel::create('Gastos por Concepto', function($excel) use ($query)
        {

            $excel->sheet('Compras', function($sheet) use ($query)
            {

                $sheet->fromArray($query->get());

            });
        })->export('xls');
    }


    public function categorias_reporte_xls(Request $request)
    {

        $query = $this->query_reporte_categoria($request);

        Excel::create('Gastos por Concepto', function($excel) use ($query)
        {
            $excel->sheet('Compras', function($sheet) use ($query)
            {
                $sheet->fromArray($query->get());
            });
        })->export('xls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Compra $compra
     * @return Response
     */
    public function destroy(Compra $compra)
    {
        $detalles = Detallecompra::where('compra_id', $compra->id)->get();

        //dd($detalles);

        foreach ($detalles as $key => $detalle)
        {
            //dd($detalle);

            if($detalle->producto_id)
            {
                $stock_producto = Producto::where('id',$detalle->producto_id)->select('stock')
                        ->first()->stock;

                $precio_compra_promedio_producto = Producto::where('id',$detalle->producto_id)->select('precio_compra_promedio')
                        ->first()->precio_compra_promedio;

                $old_precio_compra_promedio = ( ($stock_producto*$precio_compra_promedio_producto)-($detalle->cantidad*$detalle->precio_unitario) )/($stock_producto-$detalle->cantidad);

                $old_stock = $stock_producto-$detalle->cantidad;

                //dd($old_precio_compra_promedio.'= ('.$stock_producto.'*'.$precio_compra_promedio_producto.')-('.$detalle->cantidad.'*'.$detalle->precio_unitario.')/('.$stock_producto.'+'.$detalle->cantidad.')');

                Producto::where('id',$detalle->producto_id)
                ->update
                ([
                    'precio_compra_promedio' => $old_precio_compra_promedio,
                    'stock' => $old_stock,
                ]);


            }
        }


        $this->compra->destroy($compra);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('compras::compras.title.compras')]));

        return redirect()->route('admin.compras.compra.index');
    }

    function crear_contra_asientos($compra)
    {
        $asientos = $compra->asientos_all;

        // dd($compra);

        $proveedor = Proveedor::where('id',$compra->proveedor_id)->get()->first()->razon_social;

        try
        {

            foreach ($asientos as $key => $asiento)
            {
                $contra_asiento = Asiento::create
                ([
                    'fecha' => get_actual_date_server(),
                    'operacion' => 'Anulacion de Compra',
                    'observacion' => 'Anulacion de Compra  |  Proveedor: '.$proveedor.' | Factura Nro:  '.$compra->nro_factura,
                    'usuario_create_id' => $this->auth->id(),
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
            //dd($e);

            return false;
        }

        //dd( $contra_asiento );

        return true;

    }

    public function formatFloatForSave($n){
      $n = str_replace('.', '', $n);
      $n = str_replace(",",".", $n);
      return $n;
    }

}
