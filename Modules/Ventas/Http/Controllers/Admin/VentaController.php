<?php namespace Modules\Ventas\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Ventas\Entities\Venta;
use Modules\Ventas\Repositories\VentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Clientes\Entities\Cliente;
use Modules\Cristales\Entities\Cristal;
use Modules\Productos\Entities\Producto;
use Modules\Servicios\Entities\Servicio;
use Response;
use Modules\Cristales\Entities\CategoriaCristales;
use Modules\Cristales\Entities\Cristales;
use Modules\Cristales\Entities\TipoCristales;
use Illuminate\Support\Facades\Validator;
use Input;
use Carbon\Carbon;
use Modules\Ventas\Http\Requests\VentaRequest;
use Modules\Ventas\Entities\DetalleVenta;
use Modules\Ventas\Entities\FacturaVenta;
use DB;
use Modules\Core\Contracts\Authentication;
use Yajra\Datatables\Facades\Datatables;
use Modules\Ventas\Entities\ConfigFacturaVenta;
use Modules\Ventas\Entities\ConfigSeguimientoVenta;
include( base_path().'/Modules/funciones_varias.php');
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Caja\Entities\Caja;
use Modules\Pagofacturascredito\Entities\Pagofacturacredito;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Modules\Contabilidad\Entities\Cuenta;

class VentaController extends AdminBaseController
{
    /**
     * @var VentaRepository
     */
    private $venta;

    private $auth;

    public function __construct(VentaRepository $venta,Authentication $auth)
    {
        parent::__construct();

        $this->venta = $venta;

        $this->auth=$auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index_preventa()
    {
        return view('ventas::admin.ventas.index-preventa');
    }

    public function index()
    {
        return view('ventas::admin.ventas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request )
    {
        $hay_activo = Caja::where('activo', true)->first();
        if(!$hay_activo)
        {
            flash()->error('Para Generar una Venta o Preventa debe existir una Caja Activa.');

            return redirect()->route('admin.caja.caja.index');
        }

        if(!ConfigFacturaVenta::first())
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

            ConfigSeguimientoVenta::create
            ([
                'nro_1' => intval( date('y') ),
                'nro_2' => 1
            ]);
        }

        $nro_factura = ConfigFacturaVenta::where('identificador', 'nro_factura_1')->first()->valor;
        $nro_factura = $nro_factura.' - '.ConfigFacturaVenta::where('identificador', 'nro_factura_2')->first()->valor;
        $nro_ai = ConfigFacturaVenta::where('identificador', 'nro_factura_3')->first()->valor;
        $nro_ai = str_pad($nro_ai, 3, '0', STR_PAD_LEFT);
        $nro_factura = $nro_factura.' - '.$nro_ai;

        $nro_seguimiento = ConfigSeguimientoVenta::first();

        $nro_seguimiento = $nro_seguimiento->nro_1.'/'.$nro_seguimiento->nro_2;

        $categorias = CategoriaCristales::get();

        $cristales = Cristales::get();

        $tipos = TipoCristales::get();

        $fecha = get_actual_date();

        if( $request['isVenta'] != null )//if is venta
        {
            $isVenta = true;
            $isPreventa = false;
            $isOtros = false;
        }
        if( $request['isOtros'] != null )
        {
            $isVenta = false;
            $isPreventa = false;
            $isOtros = true;
            $haber = \CuentasFijas::get('ventas.ingresos_extraordinarios');
            $debe_contado =  \CuentasFijas::get('ventas.caja');
            $debe_credito =  \CuentasFijas::get('ventas.deudores_por_venta');
        }
        if( $request['isPreventa'] != null )
        {
            $isVenta = false;
            $isPreventa = true;
            $isOtros = false;
        }



        return view('ventas::admin.ventas.create', compact('clientes','cristales','productos','servicios','isVenta','isPreventa','isOtros','categorias','cristales','tipos','nro_factura','nro_seguimiento', 'fecha', 'haber','debe_contado', 'debe_credito' ));
        
    }

    public function nro_seguimiento_exist(Request $request )
    {
        return $result;
    }


    public function indexAjax(Request $request)
    {
        if($request['estado']=="terminado")
        {   
            $venta = "venta";
            $preventa = "preventa";

            $query = Venta::join('clientes__clientes','clientes__clientes.id','=','cliente_id')
                    ->leftjoin('ventas__facturaventas','ventas__facturaventas.venta_id','=','ventas__ventas.id')
                    ->orderBy('ventas__ventas.fecha_venta','desc')
                    ->orderBy('ventas__ventas.id','desc')
                    ->select('ventas__ventas.*',
                             'ventas__facturaventas.nro_factura as nro_factura',
                             'clientes__clientes.razon_social', 
                             'ventas__facturaventas.id as factura_id');
                    
                        $query = $query->where("ventas__ventas.estado", "terminado")
                            ->where(function ($query) use ($venta, $preventa) {
                            $query->where("ventas__ventas.tipo", '=', $preventa)
                                ->orwhere("ventas__ventas.tipo", '=', $venta);
                        });
        }
        else
        {
            $query = Venta::join('clientes__clientes','clientes__clientes.id','=','cliente_id')
                    ->leftjoin('ventas__facturaventas','ventas__facturaventas.venta_id','=','ventas__ventas.id')
                    ->orderBy('ventas__ventas.fecha_venta','desc')
                    ->orderBy('ventas__ventas.id','desc')
                    ->select('ventas__ventas.*',
                             'ventas__facturaventas.nro_factura as nro_factura',
                             'clientes__clientes.razon_social', 
                             'ventas__facturaventas.id as factura_id');
        }

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla)
            {
                $asEdit = "admin.ventas.venta.edit";

                $asDestroy = "admin.ventas.venta.destroy";

                $as_edit_factura = 'admin.ventas.facturaventa.edit';

                $editRoute = route($asEdit, [$tabla->id]);

                if($tabla->tipo == 'preventa')
                {
                    $deleteRoute = route($asDestroy, [$tabla->id], 'preventa=1');
                }
                else 
                {
                    $deleteRoute = route($asDestroy, [$tabla->id]);
                }

                if($tabla->anulado)
                {
                    $deleteRoute = '';
                }

                $edit_factura_route = route($as_edit_factura, [$tabla->factura_id]);


                $buttons="<div class='btn-group' style='aligh:center;''>";
                if($tabla->factura_id )
                {
                    $buttons=$buttons."<a href='".$edit_factura_route." 'class='btn btn-default btn-flat'>
                                            <strong>DETALLES</strong>
                                        </a>";
                }
                

                if( ($tabla->estado == 'preventa' && !$tabla->pago_final) )
                {
                    if($tabla->anulado)
                    {
                        $buttons = $buttons."<a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                            <strong>DETALLES</strong>
                                        </a>";
                    }
                    else
                    {
                        $buttons = $buttons."<a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                            <strong>COMPLETAR VENTA</strong>
                                        </a>";
                    }
                    
                }
                else
                {
                    
                }
            if($deleteRoute!='')  
            {          
                /*
                $buttons = $buttons."
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>";
                            */
            }
            $buttons = $buttons."</div>";

                return $buttons;
            })
            ->addColumn('monto_pagar', function ($tabla)
            {
                return number_format(($tabla->monto_total-$tabla->total_pagado), 0, '', '.');
            })
            ->filter(function ($query) use ($request)
            {
                
                if ($request->has('fecha_inicio_entrega') && trim($request->has('fecha_inicio_entrega') !== '') )
                    $query->where('fecha_entrega', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio_entrega'))->modify('-1 day')  );
                
                if ($request->has('fecha_fin_entrega') && trim($request->has('fecha_fin_entrega') !== '') )
                    $query->where('fecha_entrega', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin_entrega'))  );


                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
                    $query->where('fecha_venta', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
                
                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
                    $query->where('fecha_venta', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                
                if ($request->has('nro_seguimiento')  && trim($request->has('nro_seguimiento') !== '') )
                    $query->where('nro_seguimiento', 'like', "%{$request->get('nro_seguimiento')}%");

                if ($request->has('factura')  && trim($request->has('factura') !== '') )
                    $query->where('ventas__facturaventas.nro_factura', 'like', "%{$request->get('factura')}%");
                
                if ($request->has('estado')  && trim($request->has('estado') !== '') )
                    $query->where('estado', 'like', "%{$request->get('estado')}%");

                if ($request->has('anulado')  && trim($request->has('anulado') !== '') )
                    $query->where('ventas__ventas.anulado', $request->get('anulado'));

                if ($request->has('cliente')  && trim($request->has('cliente') !== '') )
                    $query->where('razon_social', 'like', "%{$request->get('cliente')}%")
                    ->orwhere('clientes__clientes.cedula', 'like', "%{$request->get('cliente')}%");
                    
                
            })

            ->editColumn('total_iva', function($tabla)
            {
                return number_format($tabla->total_iva, 0, '', '.');
            })
            ->editColumn('anulado',function($tabla)
            {
                if($tabla->anulado == true)
                {
                    return "SI";
                }
                else
                {
                    return "NO";
                }
            })
            ->editColumn('total_pagado', function($tabla)
            {
                return number_format($tabla->total_pagado, 0, '', '.');
            })
            ->editColumn('monto_total', function($tabla)
            {
                return number_format($tabla->monto_total, 0, '', '.');
            })
            ->editColumn('razon_social', function($tabla)
            {
                if($tabla->factura_id)
                    return $tabla->razon_social . " -CI:" . number_format($tabla->cliente->cedula, 0, '', '.');
 
                $asEdit = "admin.ventas.venta.edit"; 
                 
                $editRoute = route($asEdit, [$tabla->id]); 
 
                return '<a href="'.$editRoute.'"style="color:black;">' . $tabla->razon_social . ' -CI: ' . number_format($tabla->cliente->cedula, 0, '', '.') . '</a>'; 
            })
            ->editColumn('fecha_venta', function($tabla)
            {
                return $tabla->format('fecha_venta', 'date');
            })
            ->editColumn('fecha_entrega', function($tabla)
            {
                if($tabla->fecha_entrega)
                    return $tabla->format('fecha_entrega', 'date');
                else
                    return "";
            })
            ->editColumn('nro_seguimiento', function($tabla)
            {
                if($tabla->factura_id)return $tabla->nro_seguimiento;

                $asEdit = "admin.ventas.venta.edit";
                
                $editRoute = route($asEdit, [$tabla->id]);

                return '<a href="'.$editRoute.'" style="color:black;">'.$tabla->nro_seguimiento.'</a>';
            })
            ->make(true);

        //dd( $object );

        return $object;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $re)
    {   
        if ($re['entrega_preventa']) 
            $re['entrega'] = $re['entrega_preventa'];
        

        date_default_timezone_set ( 'America/Asuncion' );
        $caja_id = Caja::where('activo', true)->first()->id;

        $re['monto_total'] = str_replace('.', '', $re['monto_total'] );

        $re['total_pagado'] = str_replace('.', '', $re['total_pagado']);

        $re['total_iva_5'] = str_replace('.', '', $re['total_iva_5']);

        $re['total_iva_10'] = str_replace('.', '', $re['total_iva_10']);

        $re['total_iva'] = str_replace('.', '', $re['total_iva']);

        $re['fecha_venta'] = Carbon::createFromFormat('d/m/Y', $re['fecha_venta']);
        if( $re['fecha_entrega'] )
            $re['fecha_entrega'] = Carbon::createFromFormat('d/m/Y', $re['fecha_entrega']);
        

        $re['descuento_total'] = (int)str_replace('.', '', $re['descuento_total']);

        $productos = $re['nombre_producto'];

        $total_iva_10 = 0;

        $total_iva_5 = 0;

        $grabado_excenta = 0;

        $total_item_con_iva_10 = 0;

        $total_item_con_iva_5 = 0;

        $grabado_5 = 0;

        $grabado_10 = 0;
        $cantidad_array = collect($re['cantidad']);
        $cantidad_array->transform(function ($item, $key) 
        {
            $item = str_replace('.', '', $item);
            $item = str_replace(",",".", $item);
            return (double)$item;
        });
        $re['cantidad'] = $cantidad_array->toArray();

        for ($i=0; $i < count($re['cantidad']) ; $i++) 
        { 
            $precio_unitario = intval( str_replace('.', '', $re['precio_unitario'][$i]) );

            $cantidad = $re['cantidad'][$i];

            if($re['iva'][$i] == '11')
            {
                $total_iva_10 += ($precio_unitario*$cantidad)/11;

                $total_item_con_iva_10 += $precio_unitario*$cantidad;
            }
            else if($re['iva'][$i] == '21')
            {
                $total_iva_5 += ($precio_unitario*$cantidad)/21;

                $total_item_con_iva_5 += $precio_unitario*$cantidad;
            }
            else
            {
                $grabado_excenta += $precio_unitario*$cantidad;
            }
        }

        $grabado_excenta = intval($grabado_excenta);
        $grabado_5 = intval($grabado_5);
        $grabado_10 = intval($grabado_10);
        $total_iva_10 = intval($total_iva_10); 
        $total_iva_5 = intval($total_iva_5); 

        $grabado_10 = $total_item_con_iva_10 - $total_iva_10;

        $grabado_5 = $total_item_con_iva_5 - $total_iva_5;

        $total_suma = $grabado_excenta + $grabado_5 + $grabado_10 + $total_iva_10 + $total_iva_5;

        //dd('EXCENTA='.$grabado_excenta.' GRABADO 5% ='.$grabado_5.' GRABADO 10% ='.$grabado_10.' IVA 5%='.$total_iva_5.' IVA 10%='.$total_iva_10.' TOTAL='.$re->monto_total.' TOTAL DE SUMA='.$total_suma);

        //details
        $producto_id = $re['producto_id'];

        $servicio_id = $re['servicio_id'];

        $cristal_id = $re['cristal_id'];

        $cantidad = $re['cantidad'];

        $iva = $re['iva'];

        $precio_unitario = $re['precio_unitario'];

        $precio_total = $re['precio_total'];

        if( $re['isVenta'] )
        {
            $estado = 'terminado';

            $tipo = 'venta';

            $entrega = null;

            if($re['total_pagado'] >= $re['monto_total'])
            {
                $re['total_pagado'] = $re['monto_total'];
            }

        }
        else
        {
            $tipo = $re['tipo'];

            if ($tipo[0]=="otros") 
            {
                $re['nro_seguimiento'] =0;

                $estado = 'terminado';

                $tipo = 'otros';

                $entrega = null;

                $debe_id = $re['deber_id'];
                 
                $haber_id = $re['haber_id'];

                if($re['total_pagado'] >= $re['monto_total'])
                {
                    $re['total_pagado'] = $re['monto_total'];
                }
            }

            else
            {
                $estado = 'preventa';

                $tipo = 'preventa';

                $entrega = str_replace('.', '', $re['entrega'] );

                $re['total_pagado'] = $entrega;

                if((int)$entrega >= $re['monto_total'])
                    $entrega = $re['monto_total'];
/*
                if($entrega >= $re['monto_total'])
                {
                    $estado = 'terminado';
                }
*/
            }

        }
        DB::beginTransaction();

        try
        {
            //dd( $re->all() );
            $venta = Venta::create
            ([
                'cliente_id' => $re['cliente_id'],
                'caja_id' => $caja_id,
                'nro_seguimiento' => $re['nro_seguimiento'],
                'tipo' => $tipo,
                'fecha_venta' => $re['fecha_venta'],
                'fecha_entrega' => $re['fecha_entrega']?$re['fecha_entrega']:$re['fecha_venta'],
                'ojo_izq' => $re['ojo_izq'],
                'ojo_der' => $re['ojo_der'],
                'ojo_izq_cercano' => $re['ojo_izq_cercano'],
                'ojo_der_cercano' => $re['ojo_der_cercano'],
                'distancia_interpupilar' => $re['distancia_interpupilar'],
                'monto_total' => $re['monto_total'],
                'monto_total_letras' => $re['monto_total_letra'],
                'descuento_total' => $re['descuento_total'],
                'grabado_excenta' => $grabado_excenta,
                'grabado_5' => $grabado_5,
                'grabado_10' => $grabado_10,
                'total_iva_5' => $re['total_iva_5'],
                'total_iva_10' => $re['total_iva_10'],
                'total_iva_5' => str_replace('.', '', $re['total_iva_5']),
                'total_iva_10' => str_replace('.', '', $re['total_iva_10']),
                'total_iva' => $re['total_iva'],
                'observacion_venta' => $re['observacion_venta'],
                'entrega' => $entrega,
                'pago_final' => null,
                'estado' => $estado,
                'total_pagado' => (int)$re['total_pagado'],
                'usuario_sistema_id_create' => $this->auth->id(),
                'anulado' => false
            ]);

            //dd($tipo);
            //dd(' monto total='.$re['monto_total'].' total pagado por cliente='.$re['total_pagado'].' entrega='.$entrega );

            if(($re['total_pagado'] > 0  && $tipo == 'venta') || ($re['total_pagado'] > 0  && $tipo == 'otros'))
            {   
                
                $pago = Pagofacturacredito::create
                ([
                    'venta_id' => $venta->id,
                    'caja_id' => $caja_id,
                    'fecha' => $re['fecha_venta'],
                    'forma_pago' => $re['forma_pago'],
                    'monto' => $re['total_pagado']
                ]);
                
            }
            else if($re['total_pagado'] > 0  && $tipo == 'preventa')
            {
                $cliente = Cliente::where('id',$re['cliente_id'])->get()->first()->razon_social;
                $pago = Pagofacturacredito::create
                ([
                    'venta_id' => $venta->id,
                    'caja_id' => $caja_id,
                    'fecha' => $re['fecha_venta'],
                    'forma_pago' => $re['forma_pago'],
                    'monto' => $re['total_pagado']
                ]);
                $asiento = Asiento::create
                ([
                    'fecha' => $re['fecha_venta'],
                    'observacion' => 'Preventa  |  Cliente: '.$cliente.' | Sobre N°: '.$re['nro_seguimiento'],
                    'operacion' => 'Preventa',
                    'usuario_create_id' => $this->auth->id(),
                    'entidad_type' => Pagofacturacredito::class,
                    'entidad_id' => $pago->id
                ]);

                //Caja
                AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('ventas.preventa.pago_inicial.caja.debe')->id,//Caja
                    'debe' => $re['total_pagado'],
                    'haber' => 0,
                    'observacion' => ''
                ]);

                AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('ventas.preventa.pago_inicial.anticipos_clientes.haber')->id,
                    'debe' => 0,
                    'haber' => $re['total_pagado'],
                    'observacion' => ''
                ]);

                
            }
//***************************venta
            if ($tipo != "otros") 
                ConfigSeguimientoVenta::first()->increment('nro_2');
            
            

            if($re['generar_factura'] && $estado == 'terminado')
            {

                $factura = FacturaVenta::create
                ([
                    'venta_id' => $venta->id,
                    'nro_factura' => $re['nro_factura'],
                    'fecha' => $venta->fecha_venta,
                    'anulado' => false,
                    'tipo_factura' => $re['tipo_factura'],
                    'usuario_sistema_id_create' => $this->auth->id()
                ]);
/************************ASIENTOS*************************/
                if($re['tipo_factura'] == 'contado')
                {
                    if ($tipo != 'otros')
                    {
                        $asiento = Asiento::create
                        ([
                            'fecha' => $re['fecha_venta'],
                            'observacion' => 'Venta al Contado  | Cliente:  '.$venta->cliente->razon_social.' | Factura Nro:  '.$re['nro_factura'].' |  Sobre Nro:  '.$re['nro_seguimiento'],
                            'operacion' => 'Venta Contado',
                            'usuario_create_id' => $this->auth->id(),
                            'entidad_type' => FacturaVenta::class,
                            'entidad_id' => $factura->id
                        ]);
                    }
                    else
                    {
                        $asiento = Asiento::create
                        ([
                            'fecha' => $re['fecha_venta'],
                            'observacion' => 'Otras Ventas al Contado  | Cliente:  '.$venta->cliente->razon_social.' | Factura Nro:  '.$re['nro_factura'].' |  Sobre Nro:  '.$re['nro_seguimiento'],
                            'operacion' => 'Venta Contado',
                            'usuario_create_id' => $this->auth->id(),
                            'entidad_type' => FacturaVenta::class,
                            'entidad_id' => $factura->id
                        ]);
                    }

                    if ($tipo != 'otros')
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.contado.facturaventa.caja.debe')->id,
                            'debe' => $re['monto_total'],
                            'haber' => 0,
                            'observacion' => ''
                        ]);

                        /*--DETAILS--*/
                        if($venta->total_iva > 0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.contado.facturaventa.mercaderias_gravadas_iva.haber')->id, 
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);

                            //IVA - Credito Fiscal
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.contado.facturaventa.iva_credito_fiscal.haber')->id, 
                                'debe' => 0,
                                'haber' => $re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                        else
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.contado.facturaventa.mercaderias_excentas_iva.haber')->id, 
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                    }
                    //Si es tipo de venta es "otras" ventas el asiento se genera en otras cuentas
                    else
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => $debe_id,//Ingresos Extraordinarios
                            'debe' => $re['monto_total'],
                            'haber' => 0,
                            'observacion' => ''
                        ]);
                        /*--DETAILS--*/
                        if($venta->total_iva > 0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => $haber_id,//Caja
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);

                            //IVA - Credito Fiscal
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' =>  \CuentasFijas::get('ventas.otras_ventas.contado.facturaventa.iva_credito_fiscal.haber')->id, 
                                'debe' => 0,
                                'haber' => $re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                        else
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => $haber_id,//Caja
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                    }
                        
                }

                else if($re['tipo_factura'] == 'credito')
                {
                    if ($tipo != "otros") 
                    {
                        $asiento = Asiento::create
                        ([
                            'fecha' => $re['fecha_venta'],
                            'observacion' => 'Venta a Crédito | Cliente : '.$venta->cliente->razon_social.'  | Factura Nro: '.$re['nro_factura'].' |  Sobre Nro: '.$re['nro_seguimiento'],
                            'operacion' => 'Venta a Crédito',
                            'usuario_create_id' => $this->auth->id(),
                            'entidad_type' => FacturaVenta::class,
                            'entidad_id' => $factura->id
                        ]);
                    }
                    else
                    {
                        $asiento = Asiento::create
                        ([
                            'fecha' => $re['fecha_venta'],
                            'observacion' => 'Otras Ventas a Crédito | Cliente : '.$venta->cliente->razon_social.'  | Factura Nro: '.$re['nro_factura'].' |  Sobre Nro: '.$re['nro_seguimiento'],
                            'operacion' => 'Venta a Crédito',
                            'usuario_create_id' => $this->auth->id(),
                            'entidad_type' => FacturaVenta::class,
                            'entidad_id' => $factura->id
                        ]);
                    }
                    if($tipo != "otros")
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.credito.facturaventa.deudores_por_venta.debe')->id,
                            'debe' => $re['monto_total'],
                            'haber' => 0,
                            'observacion' => ''
                        ]);
                        //Costos de Mercaderias
                        if($re['total_iva']>0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.credito.facturaventa.mercaderias_gravadas_iva.haber')->id,
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);

                            //IVA - Credito Fiscal 
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.credito.facturaventa.iva_credito_fiscal.haber')->id,
                                'debe' => 0,
                                'haber' => $re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                        else
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.credito.facturaventa.mercaderias_excentas_iva.haber')->id,
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                        if(isset($pago))
                        {
                            /*ASIENTO DEL PAGO*/
                            $asiento_pago = Asiento::create
                            ([
                                'fecha' => $re['fecha_venta'],
                                'observacion' => 'Pago de Venta a Crédito  |  Cliente:  '.$venta->cliente->razon_social.'  |  Factura Nro:  '.$re['nro_factura'],
                                'operacion' => 'Recibos',
                                'usuario_create_id' => $this->auth->id(),
                                'entidad_type' => Pagofacturacredito::class,
                                'entidad_id' => $pago->id
                            ]);
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento_pago->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.credito.pago.caja.debe')->id,
                                'debe' => $venta->total_pagado,
                                'haber' => 0,
                                'observacion' => ''
                            ]);
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento_pago->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.credito.pago.deudores_por_venta.haber')->id,
                                'debe' => 0,
                                'haber' => $venta->total_pagado,
                                'observacion' => ''
                            ]);
                        }
                    }
                    else//si tipo == otros
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.otras_ventas.credito.facturaventa.deudores_por_venta.debe')->id, //Caja si es contado, deudores por ventas si es creditos
                            'debe' => $re['monto_total'],
                            'haber' => 0,
                            'observacion' => ''
                        ]);
                        //Costos de Mercaderias
                        if($re['total_iva']>0)
                        { //dd($haber_id);
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => $haber_id,//Ingresos Extraordinarios(default)
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);

                            
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.otras_ventas.credito.facturaventa.iva_credito_fiscal.haber')->id,//IVA - Credito Fiscal 
                                'debe' => 0,
                                'haber' => $re['total_iva'],
                                'observacion' => ''
                            ]);
                        }
                        else
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => $haber_id,//Ingresos Extraordinarios(default)
                                'debe' => 0,
                                'haber' => $re['monto_total']-$re['total_iva'],
                                'observacion' => ''
                            ]);
                        }

                        if(isset($pago))
                        {
                            /*ASIENTO DEL PAGO*/
                            $asiento_pago = Asiento::create
                            ([
                                'fecha' => $re['fecha_venta'],
                                'observacion' => 'Pago de Otras Venta a Crédito  |  Cliente:  '.$venta->cliente->razon_social.'  |  Factura Nro:  '.$re['nro_factura'],
                                'operacion' => 'Recibos',
                                'usuario_create_id' => $this->auth->id(),
                                'entidad_type' => Pagofacturacredito::class,
                                'entidad_id' => $pago->id
                            ]);
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento_pago->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.otras_ventas.credito.pago.caja.debe')->id,
                                'debe' => $venta->total_pagado,
                                'haber' => 0,
                                'observacion' => ''
                            ]);
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento_pago->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.otras_ventas.credito.pago.deudores_por_venta.haber')->id,
                                'debe' => 0,
                                'haber' => $venta->total_pagado,
                                'observacion' => ''
                            ]);
                        }
                    }   
                }

/************************ASIENTOS*************************/
                ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');
            }
        
            for($i = 0; $i < count($cantidad); $i++)
            {
                if(!$servicio_id[$i])
                    $servicio_id[$i] = null;
                if(!$cristal_id[$i])
                    $cristal_id[$i] = null;
                if(!$producto_id[$i])
                    $producto_id[$i] = null;

                // if($producto_id[$i]== null && $servicio_id[$i] == null && $cristal_id[$i] == null)
                // {
                //     return redirect()->back()->withErrors($validator)->withInput();
                // }

                if($producto_id[$i]!=null)
                {
                    $stock_producto = DB::table('productos__productos')
                        ->where('id',$producto_id[$i])->select('stock')
                        ->first()->stock;

                    DB::table('productos__productos')
                        ->where('id',$producto_id[$i])
                        ->update(['stock' => ($stock_producto-$cantidad[$i] )]);
                }

                $costo_unitario = 0;

                if($producto_id[$i])
                {
                    $costo_unitario = Producto::where('id', $producto_id[$i])->first()->precio_compra_promedio;
                }
                else if($cristal_id[$i])
                {
                    $costo_unitario = TipoCristales::where('id', $cristal_id[$i])->first()->precio_costo;
                }

                $detalles[] = DetalleVenta::create
                ([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto_id[$i] ,
                    'servicio_id' => $servicio_id[$i] ,
                    'cristal_id' => $cristal_id[$i] ,
                    'descripcion'=> $productos[$i],
                    'cantidad' => $cantidad[$i],
                    'iva' => $iva[$i],
                    'precio_unitario' => str_replace('.', '', $precio_unitario[$i]) ,
                    'costo_unitario' => $costo_unitario,
                    'precio_total' => str_replace('.', '', $precio_total[$i]) ,

                ]);
                
                

            }
        }
        catch (ValidationException $e)
        {
            DB::rollBack();

            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        if($tipo == 'preventa')
            flash()->success('Preventa creada satisfactoriamente');
        else
            flash()->success('Venta creada satisfactoriamente');

        if($re['is_otras_ventas'])
        {
            flash()->success('Venta creada satisfactoriamente');

            return redirect()->route('admin.ventas.otras_ventas.index');
        }

/*
        if(isset($asiento))
            return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);
*/     
        if($re['generar_factura'])
        {
            if($re['total_pagado']<$re['monto_total'])
                return redirect()->route('admin.ventas.venta.index');
            else
                return redirect()->route('admin.ventas.venta.index');
        }
        else
        {
            if($tipo == 'preventa')
            {
                return redirect()->route('admin.ventas.venta.index_preventa');
            }
            else
            {
                return redirect()->route('admin.ventas.venta.index');
            }
            
        }
    }

    public function seleccion()
    {

        return view('ventas::admin.ventas.seleccion');
    }

    public function seleccion_Finish()
    {

        return view('ventas::admin.ventas.seleccion');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Venta $venta
     * @return Response
     */
    public function edit(Venta $venta, Request $re)
    {
        $venta = Venta::with('factura')->where('id', $venta->id)->first();

        $categorias = CategoriaCristales::get();

        $cristales = Cristales::get();

        $tipos = TipoCristales::get();

        $detalles = DetalleVenta::with('producto')->where('venta_id', $venta->id)->get();    

        $nro_factura = ConfigFacturaVenta::where('identificador', 'nro_factura_1')->first()->valor;
        $nro_factura = $nro_factura.' - '.ConfigFacturaVenta::where('identificador', 'nro_factura_2')->first()->valor;
        $nro_factura = $nro_factura.' - '.str_pad(ConfigFacturaVenta::where('identificador', 'nro_factura_3')->first()->valor, 3, '0', STR_PAD_LEFT);

        if($venta->tipo == 'preventa')
        {
            $isVenta = false;
            $isPreventa = true;
        }
        else
        {
            $isVenta = true;
            $isPreventa = false;
        }

        $venta->fecha_venta = $venta->format('fecha_venta', 'date');
        if($venta->fecha_entrega)
            $venta->fecha_entrega = $venta->format('fecha_entrega', 'date');
        $isOtros = false;

        //dd( $venta->detalles[0]->producto );
        $permisos = $re->user()->get_full_permisos;
        return view('ventas::admin.ventas.edit', compact('venta','categorias','cristales','tipos','isVenta','detalles','nro_factura', 'isOtros', 'permisos'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Venta $venta
     * @param  Request $request
     * @return Response
     */
    public function update(Venta $venta, Request $request)
    {   

         $hay_activo = Caja::where('activo', true)->first(); 
 
        if(!$hay_activo) 
        { 
 
            flash()->error('Debe haber una caja activa, cree una.'); 
 
            return redirect()->route('admin.caja.caja.index'); 
        } 
        date_default_timezone_set ( 'America/Asuncion' );

        $eliminar = $request->get('eliminar');

        $detalles_ventas_bd = DetalleVenta::where('venta_id', $venta->id)->get();
        //header
        $eliminar_id = $request->get('eliminar_id');

        $isVenta = $request->get('isVenta');

        $detalle_venta_id = $request->get('detalle_venta_id');

        $cliente_id = $request->get('cliente_id');

        $usuario_sistema_id = $this->auth->id();

        $nro_seguimiento = $request->get('nro_seguimiento');

        $fecha_venta= $request->get('fecha_venta');

        $fecha_entrega = $request->get('fecha_entrega');

        if($fecha_venta)
            $fecha_venta = Carbon::createFromFormat('d/m/Y', $fecha_venta);

        if($fecha_entrega)
            $fecha_entrega = Carbon::createFromFormat('d/m/Y', $fecha_entrega);

        $forma_pago = $request->get('forma_pago');

        $ojo_izq = $request->get('ojo_izq');

        $ojo_der = $request->get('ojo_der');

        $distancia_interpupilar = $request->get('distancia_interpupilar');

        $monto_total = $request->get('monto_total');

        $monto_total_letras = $request->get('monto_total_letra');

        $total_iva_5 = $request->get('total_iva_5');

        $total_iva_10 = $request->get('total_iva_10');

        $total_iva = $request->get('total_iva');

        $observacion_venta = $request->get('observacion_venta');

        if($venta->tipo == 'preventa')
        {
            $entrega = intval(str_replace('.', '', $request->get('entrega')));

            $pago_final = intval(str_replace('.', '', $request->get('pago_final')));

            $total_pagado = ($entrega + $pago_final);

            if($total_pagado >= $venta->monto_total )
            {
                $vuelto_final = $total_pagado-$venta->monto_total;

                $total_pagado = $venta->monto_total;

                $pago_final = $pago_final-$vuelto_final;

                $estado = 'terminado';
            }
            else
            {
                if($request['tipo_factura'] == "credito")
                {
                    $estado = 'terminado';
                }
                else
                {
                    $estado = 'preventa';
                }
                
            }
        }
        else
        {
            $entrega = null;

            $pago_final = null;

            $total_pagado = str_replace('.', '', $request->get('total_pagado') );

            $estado = 'terminado';
        }

        $anulado = $request->get('anulado');

        //details
        $producto_id = $request->get('producto_id');

        $servicio_id = $request->get('servicio_id');

        $cristal_id = $request->get('cristal_id');

        $cantidad = $request->get('cantidad');
        $cantidad_array = collect( $cantidad );
        $cantidad_array->transform(function ($item, $key) 
        {
            $item = str_replace('.', '', $item);
            $item = str_replace(",",".", $item);
            return (double)$item;
        });
        $cantidad = $cantidad_array->toArray();

        $iva = $request->get('iva');

        $precio_unitario = $request->get('precio_unitario');

            if($precio_unitario)
                foreach ($precio_unitario as $key => $precio) 
                    $precio_unitario[$key] = str_replace('.', '', $precio);
            
            

        $precio_total = $request->get('precio_total');

            if($precio_total)
                foreach ($precio_total as $key => $precio) 
                    $precio_total[$key] = str_replace('.', '', $precio);
                
            

        DB::beginTransaction();

        try
        {
            if($venta->estado == 'terminado')
            {
                Venta::where('id', $venta->id)->update
                ([
                    'usuario_sistema_id_edit' => $this->auth->id(),
                    'anulado' => $anulado
                ]);

                FacturaVenta::where('venta_id', $venta->id)
                ->update
                ([
                    'anulado' => $anulado
                ]);
            }
            else
            {
                Venta::where('id',$venta->id)->update
                ([
                    'cliente_id' => $cliente_id,
                    'nro_seguimiento' => $nro_seguimiento,
                    'fecha_venta' => $fecha_venta,
                    'fecha_entrega' => $fecha_entrega,
                    'ojo_izq' => $ojo_izq,
                    'ojo_der' => $ojo_der,
                    'distancia_interpupilar' => $distancia_interpupilar,
                    'monto_total' => str_replace('.', '', $monto_total ),
                    'monto_total_letras' => $monto_total_letras,
                    'total_iva_5' => str_replace('.', '', $total_iva_5),
                    'total_iva_10' => str_replace('.', '', $total_iva_10),
                    'total_iva' => str_replace('.', '', $total_iva),
                    'observacion_venta' => $observacion_venta,
                    'entrega' => $entrega,
                    'pago_final' => $pago_final,
                    'estado' => $estado,
                    'total_pagado' => str_replace('.', '', $total_pagado),
                    'usuario_sistema_id_edit' => $this->auth->id()
                ]);

                if($pago_final > 0)
                {
                        $pago = Pagofacturacredito::create
                        ([
                            'venta_id' => $venta->id,
                            'caja_id' => $hay_activo->id,
                            'fecha' => date('Y-m-d'),
                            'forma_pago' => $request['forma_pago'],
                            'monto' => $pago_final
                        ]);

                    if( $request['tipo_factura'] == 'credito' )
                    {
                        $asiento = Asiento::create
                        ([
                            'fecha' => date('Y-m-d'),
                            'observacion' => 'Cobranza segun numero de recibo',
                            'operacion' => 'Recibos',
                            'usuario_create_id' => $this->auth->id(),
                            'entidad_type' => Pagofacturacredito::class,
                            'entidad_id' => $pago->id
                        ]);

                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.credito.pago_final.caja.debe')->id,
                            'debe' => $pago_final,
                            'haber' => 0,
                            'observacion' => ''
                        ]);

                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.credito.pago_final.anticipos_clientes.haber')->id,
                            'debe' => 0,
                            'haber' => $pago_final,
                            'observacion' => ''
                        ]);
                    }
                }
                if($request['generar_factura'])
                {
                    $config = ConfigFacturaVenta::first();

                    $nro_factura = ConfigFacturaVenta::where('identificador', 'nro_factura_1')->first()->valor;

                    $nro_factura = $nro_factura.' - '.ConfigFacturaVenta::where('identificador', 'nro_factura_2')->first()->valor;

                    $nro_factura = $nro_factura.' - '.ConfigFacturaVenta::where('identificador', 'nro_factura_3')->first()->valor;
                    $venta = Venta::where('id', $venta->id)->first();
                    $factura = FacturaVenta::create
                    ([
                        'venta_id' => $venta->id,
                        'nro_factura' => $request->nro_factura,
                        'fecha' => $venta->fecha_venta,
                        'anulado' => false,
                        'tipo_factura' => $request['tipo_factura'],
                        'usuario_sistema_id_create' => $this->auth->id()
                    ]);
                    $asiento = Asiento::create
                    ([
                        'fecha' => date('Y-m-d'),
                        'observacion' => 'Preventa  |  Cliente: '.$venta->cliente->razon_social.'  | Factura Nro: '.$venta->factura->nro_factura.' | Sobre N°: '.$venta->nro_seguimiento,
                        'operacion' => 'Ventas',
                        'usuario_create_id' => $this->auth->id(),
                        'entidad_type' => FacturaVenta::class,
                        'entidad_id' => $factura->id
                    
                    ]);

                    if( $request['tipo_factura'] == 'contado' )
                    {

                        if($pago_final>0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.preventa.contado.facturaventa.caja.debe')->id, 
                                'debe' => $pago_final,
                                'haber' => 0,
                                'observacion' => ''
                            ]);
                        }

                        if($venta->entrega>0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.preventa.contado.facturaventa.anticipos_clientes.debe')->id, 
                                'debe' => $venta->entrega,
                                'haber' => 0,
                                'observacion' => ''
                            ]);
                        }
                        
                    }
                    else
                    {//A CREDITO

                        if( ($venta->monto_total -($entrega+$pago_final)) > 0)
                        {
                            AsientoDetalle::create
                            ([
                                'asiento_id' => $asiento->id,
                                'cuenta_id' => \CuentasFijas::get('ventas.preventa.credito.facturaventa.deudores_por_venta.debe')->id, 
                                'debe' => $venta->monto_total - ($pago_final+$venta->entrega),
                                'haber' => 0,
                                'observacion' => ''
                            ]);
                        }
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.credito.facturaventa.anticipos_clientes.debe')->id,
                            'debe' => ($entrega+$pago_final),
                            'haber' => 0,
                            'observacion' => ''
                        ]);
                    }
                    if($venta->total_iva > 0)
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.facturaventa.mercaderias_gravadas_iva.haber')->id,
                            'debe' => 0,
                            'haber' => $venta->monto_total-$venta->total_iva,
                            'observacion' => ''
                        ]);

                        //IVA - Credito Fiscal 
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.facturaventa.iva_credito_fiscal.haber')->id,
                            'debe' => 0,
                            'haber' => $venta->total_iva,
                            'observacion' => ''
                        ]);
                    }
                    else
                    {
                        AsientoDetalle::create
                        ([
                            'asiento_id' => $asiento->id,
                            'cuenta_id' => \CuentasFijas::get('ventas.preventa.facturaventa.mercaderias_excentas_iva.haber')->id,
                            'debe' => 0,
                            'haber' => $venta->monto_total-$venta->total_iva,
                            'observacion' => ''
                        ]);
                    }

                    ConfigFacturaVenta::where('identificador', 'nro_factura_3')->increment('valor');
                }

                for($i = 0; $i < count($cantidad); $i++)
                {
                    if( $i<count($eliminar) && $eliminar[$i] == '1')
                    {
                        if($producto_id[$i])
                        {
                            $stock_producto = DB::table('productos__productos')
                                ->where('id',$producto_id[$i])->select('stock')
                                ->first()->stock;

                            $cantidad_detalle_DB = DetalleVenta::where('id', $detalle_venta_id[$i])->first()->cantidad;

                            $stock_producto_reset = $cantidad_detalle_DB + $stock_producto;
                        

                            DB::table('productos__productos')
                                ->where('id',$producto_id[$i])
                                ->update(['stock' =>  $stock_producto_reset ]);
                        }


                        DetalleVenta::where('id', $detalle_venta_id[$i])->delete();
                    }
                    else
                    {
                        if(!$servicio_id[$i])
                            $servicio_id[$i] = null;
                        
                        if(!$cristal_id[$i])
                            $cristal_id[$i] = null;

                        if(!$producto_id[$i])
                            $producto_id[$i] = null;
                        


                        if( $detalle_venta_id[$i]!='' )
                        {
                            //SI SE ELIGIO UN PRODUCTO Y ES UN UPDATE DE UN DETALLE QUE YA EXISTIA
                          
                            if($producto_id[$i]!=null && $servicio_id[$i]==null && $cristal_id[$i]==null )
                            {
                                $stock_producto = DB::table('productos__productos')
                                    ->where('id',$producto_id[$i])->select('stock')
                                    ->first()->stock;
                                //STOCK EN EL PRODUCTO ANTES DEL UPDATE
                                    
                                $cantidad_detalle_DB = DetalleVenta::where('id', $detalle_venta_id[$i])->first()->cantidad;
                                //CANTIDAD DEL DETALLE QUE ESTA EL LA BASE DE DATOS ANTES DEL UPDATE

                                $stock_producto_reset = $cantidad_detalle_DB + $stock_producto;
                                //STOCK EN EL PRODUCTO ANTES DEL CREATE

                                $stock_update = $stock_producto_reset-$cantidad[$i];
                                
                                //AHORA HAY QUE VOLVER A QUITAR DE LA BASE DE DATOS EL STOCK VIEJO Y AGREGAR DEL UPDATE 
                            
                                DB::table('productos__productos')
                                    ->where('id',$producto_id[$i])
                                    ->update(['stock' =>  $stock_update ]);
                            }
                            

                            DetalleVenta::where('id', $detalle_venta_id[$i])->update
                            ([
                                'venta_id' => $venta->id,
                                'producto_id' => $producto_id[$i] ,
                                'servicio_id' => $servicio_id[$i] ,
                                'cristal_id' => $cristal_id[$i] ,
                                'cantidad' => $cantidad[$i],
                                'iva' => $iva[$i] ,
                                'precio_unitario' => str_replace('.', '', $precio_unitario[$i] ) ,
                                'precio_total' => str_replace('.', '', $precio_total[$i] ) ,

                            ]);
                        }
                        else
                        {
                            if(!$servicio_id[$i])
                                $servicio_id[$i] = null;
                        
                            if(!$cristal_id[$i])
                                $cristal_id[$i] = null;

                            if(!$producto_id[$i])
                                $producto_id[$i] = null;

                            else if($producto_id[$i] && !$servicio_id[$i] && !$cristal_id[$i] && $detalle_venta_id[$i]=='')
                            {
                                $stock_producto = DB::table('productos__productos')
                                    ->where('id',$producto_id[$i])
                                    ->select('stock')
                                    ->first()
                                    ->stock;

                                $stock_update = $stock_producto-$cantidad[$i];

                                DB::table('productos__productos')
                                    ->where('id',$producto_id[$i])
                                    ->update(['stock' =>  $stock_update ]);

                            }


                            DetalleVenta::create
                            ([
                                'venta_id' => $venta->id,
                                'producto_id' => $producto_id[$i] ,
                                'servicio_id' => $servicio_id[$i] ,
                                'cristal_id' => $cristal_id[$i] ,
                                'cantidad' => $cantidad[$i],
                                'iva' => $iva[$i],
                                'precio_unitario' => str_replace('.', '', $precio_unitario[$i]) ,
                                'precio_total' => str_replace('.', '', $precio_total[$i]) ,

                            ]);
                        }

                        

                    }
                }
            }

        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success('Completada Exitosamente');
/*
        if( isset($asiento) )
            return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);
*/
        if($request['generar_factura'])
        {
            if( $estado == 'preventa' )
                return redirect()->route('admin.ventas.venta.index_preventa');
            else
                return redirect()->route('admin.ventas.venta.index');
        }
        else
        {
            if( $estado == 'preventa' )
                return redirect()->route('admin.ventas.venta.index_preventa');
            else
                return redirect()->route('admin.ventas.venta.index');
        }
        
    }

    public function edit_nro_seguimiento(Request $request)
    {
        if ($request['venta_id'] != null) 
        {
                
            $nro_seguimiento = $request['nro_seguimiento'];
      
            $venta_id = $request['venta_id'];

            return view('ventas::admin.ventas.config-seguimiento', compact('nro_seguimiento', 'venta_id'));
        }
        else
        {
            $nro_seguimiento = ConfigSeguimientoVenta::first();

            if(!$nro_seguimiento)
            {
                $nro_seguimiento = ConfigSeguimientoVenta::create
                ([
                    'nro_1' => intval( date('y') ),
                    'nro_2' => 0
                ]);
            }
            return view('ventas::admin.ventas.config-seguimiento', compact('nro_seguimiento'));
        }
         
    }

    public function update_nro_seguimiento(Request $re)
    {
        if ($re['venta_id'] != null) 
        {
            Venta::where('id',$re['venta_id'])->update
            ([
                'nro_seguimiento' => $re['nro_seguimiento']
            ]);    
            flash()->success('Actualizado Correctamente');

            return view('ventas::admin.ventas.index');
        }
        else
        {
            ConfigSeguimientoVenta::where('id',$re['id'])->update
            ([
                'nro_1' => $re['nro_1'],
                'nro_2' => $re['nro_2']
            ]);

            flash()->success('Actualizado Correctamente');

            return back();
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Venta $venta
     * @return Response
     */
    public function destroy(Venta $venta)
    {
        $hay_activo = Caja::where('activo', true)->first();

        if(!$hay_activo)
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        DB::beginTransaction();
        try
        {

            Pagofacturacredito::create
            ([
                'venta_id' => $venta->id,
                'caja_id' => $hay_activo->id,
                'fecha' => get_actual_date_server(),
                'forma_pago' => 'efectivo',
                'monto' => ($venta->total_pagado*-1)
            ]);

            Venta::where('id', $venta->id)->update(['anulado' => true]);

            FacturaVenta::where('venta_id', $venta->id)->update(['anulado' => true, 'venta_id' => null]);

        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Ocurrio un error.');
            return redirect()->back();
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('ventas::ventas.title.ventas')]));

        if($venta->tipo == 'preventa')
            return redirect()->route('admin.ventas.venta.index_preventa');
        else
            return redirect()->route('admin.ventas.venta.index');   
    }
    public function reporte()
    {
        $actual_date = (object)['fecha_fin' => (new Carbon('now'))->format('d/m/Y')];
        $first_day_month = (object)['fecha_inicio' => (new Carbon('first day of this month'))->format('d/m/Y')];
        return view('ventas::admin.ventas.reporte', compact('actual_date', 'first_day_month'));
    }

    public function reporte_ajax(Request $request)
    {
        $query = $this->query_reporte($request);

        $total_ganancia = 0;

        $query->select('ventas__ventas.id as id', 
                'ventas__facturaventas.id as factura_id',
                 'ventas__facturaventas.nro_factura as nro_factura',
                 'ventas__ventas.nro_seguimiento as nro_seguimiento',
                 'clientes__clientes.razon_social as razon_social',
                 'ventas__ventas.fecha_venta as fecha_venta',
                 'ventas__ventas.monto_total as monto_total',
                 'ventas__ventas.total_pagado as total_pagado',
                 DB::raw('(SELECT ( (sum(precio_unitario*cantidad))-(sum(costo_unitario*cantidad)) ) FROM ventas__detalleventas WHERE venta_id = ventas__ventas.id) AS ganancia')
                 );

        $query2 = $query;

        foreach ($query2->get() as $key => $venta) 
            $total_ganancia += $venta->ganancia;

        $sum_total_pagado = number_format( $query->sum('total_pagado'), 0, '', '.');

        $sum_monto_total = number_format( $query->sum('monto_total'), 0, '', '.');

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla)
            {
                $as_edit_factura = 'admin.ventas.facturaventa.edit';

                $edit_factura_route = route($as_edit_factura, [$tabla->factura_id]);


            $buttons="<div class='btn-group' style='aligh:center;'>
                            <a href='".$edit_factura_route." 'class='btn btn-default btn-flat'>
                                <strong>Ver Detalles</strong>
                            </a>
                        </div>";
               

                return $buttons;
            })
            
            ->editColumn('ganancia', function($tabla) use ($query)
            {
                return number_format( $tabla->ganancia, 0, '', '.');
            })
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
            ->editColumn('fecha_venta', function($tabla) use ($query)
            {
                return $tabla->fecha_venta_format;
            })
            ->make(true);   

        $data = $object->getData(true);

        $data['total_ganancia'] = number_format($total_ganancia, 0, '', '.');

        $data['sum_total_pagado'] = $sum_total_pagado;

        $data['sum_monto_total'] = $sum_monto_total;

        return response()->json( $data );
    }
    
    function query_reporte(Request $request)
    {
        if ( $request['download_xls'] == 'yes' )
        {
            $request['fecha_inicio'] = $request['fecha_inicio2'];

            $request['fecha_fin'] = $request['fecha_fin2'];
        };

        $query = Venta::join('clientes__clientes','clientes__clientes.id','=','cliente_id')
        ->leftjoin('ventas__facturaventas','ventas__facturaventas.venta_id','=','ventas__ventas.id')
        ->where('ventas__ventas.anulado',false)
        ->where('ventas__ventas.estado', 'terminado')
        ->orderBy('ventas__facturaventas.nro_factura', "DESC");

        if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
        {
            $query->where('fecha_venta', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
        }

        if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
        {
            $query->where('fecha_venta', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
        }

        if($request['download_xls'] == 'yes')
            $query->select(
                 'ventas__facturaventas.nro_factura as Nro_de_Factura',
                 'ventas__ventas.nro_seguimiento as Nro_de_Sobre',
                 'clientes__clientes.razon_social as Cliente',
                 'ventas__ventas.fecha_venta as Fecha_de_Venta',
                 'ventas__ventas.monto_total as Monto_Total',
                 'ventas__ventas.total_pagado as Total_Pagado',
                 DB::raw('(SELECT ( (sum(precio_unitario*cantidad))-(sum(costo_unitario*cantidad)) ) FROM ventas__detalleventas WHERE venta_id = ventas__ventas.id) AS Ganancia'));
        

        else if($request['download_xls'] == "yes-with-detalles")
            $query->select(
                 'ventas__ventas.*',
                 DB::raw('(SELECT ( (sum(precio_unitario*cantidad))-(sum(costo_unitario*cantidad)) ) FROM ventas__detalleventas WHERE venta_id = ventas__ventas.id) AS Ganancia'));

        return $query;
    }

    public function reporte_xls(Request $request)
    {
        $query = $this->query_reporte($request)->orderBy('nro_factura', 'DESC');

        $ventas = Venta::where('ventas__ventas.anulado',false)
        ->where('ventas__ventas.estado', 'terminado')
        ->select('ventas__ventas.*');

        if ($request->has('fecha_inicio2') && trim($request->has('fecha_inicio2') !== '') )
            $ventas->where('fecha_venta', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio2'))->modify('-1 day')  );
        
        if ($request->has('fecha_fin2') && trim($request->has('fecha_fin2') !== '') )
            $ventas->where('fecha_venta', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin2'))  );
        
        $ventas = $ventas->orderBy('fecha_venta', 'DESC')->orderBy('id', 'desc')->get();

        if($request['download_xls'] == "yes")
        {
            $query = $query->get()->toArray();

            $collection = collect([]);
            foreach ($query as $key => $value) 
            {
                $value['Fecha_de_Venta'] = date_from_server($value['Fecha_de_Venta']);
                $collection[] = array_merge($value, ['Fecha Inicio: '.$request->fecha_inicio2 => '', 'Fecha Fin: '.$request->fecha_fin2 => '', 'Fecha de Doc: '.date('d/m/Y') => '']);
            }
            $query = $collection;

            Excel::create('Reporte_Ventas_'.date('d-m-Y'), function($excel) use ($query) 
            {
                $excel->sheet('Ventas', function($sheet) use ($query) 
                {
                    $sheet->fromArray($query);
     
                });
            })->export('xls');
        }
        else if($request['download_xls'] == "yes-with-detalles")
        {
           //return view('ventas::admin.ventas.reporte.reporte-venta-excel-principal', compact('ventas'));
            Excel::create('Reporte_Ventas_Detalles_' . date("Y_m_d"), function($excel) use ($ventas, $request)
            {
                $excel->sheet('Reporte_Ventas_Detalles', function($sheet) use ($ventas, $request)
                {
                    $fecha_de_documento = date("d/m/Y");
                    $fecha_inicio = $request->fecha_inicio2;
                    $fecha_fin = $request->fecha_fin2;

                    $sheet->loadView( 'ventas::admin.ventas.reporte.reporte-venta-excel-principal', compact('ventas', 'fecha_de_documento', 'fecha_inicio', 'fecha_fin') );
                });
            })->export('xls');
        }
    }

    public function anular_factura(Venta $venta, Request $re)
    {
        $re->anulado = intval( $re->anulado );

        if( $re->anulado )
        {
            Venta::where('id', $venta->id)->update(['anulado'=> $re->anulado]);

            foreach ($venta->detalles as $key => $detalle) 
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

            $this->crear_contra_asientos($venta);

            flash()->success('Anulado Correctamente');
        }
        
        return redirect()->route('admin.ventas.venta.index');
    }

    public function anular_asientos_preventa(Venta $preventa, Request $re)
    {

        $asientos = $preventa->asientos_all;
        foreach ($asientos as $key => $asiento) 
            $asiento->generar_contraasiento( $re->user()->id );

        $preventa->anulado = true;
        $preventa->save();
        flash()->success('Preventa Anulada Correctamente');
        return redirect()->route('admin.ventas.venta.index');
    }

    function crear_contra_asientos($venta)
    {
        $asientos = $venta->asientos_all;

        try
        {

            foreach ($asientos as $key => $asiento) 
            {
                $contra_asiento = Asiento::create
                ([
                    'fecha' => get_actual_date_server(),
                    'operacion' => 'Anulacion de Asiento('.$asiento->operacion.')',
                    'observacion' => $asiento->observacion,
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
            return false;
        }
        return true;
        
    }   
}
