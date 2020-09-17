<?php namespace Modules\Empleados\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Empleados\Entities\PagoEmpleado;
use Modules\Empleados\Entities\Empleado;
use Modules\Empleados\Repositories\PagoEmpleadoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
use Modules\Core\Contracts\Authentication;
use DB;
use DateTime;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Entities\Cuenta;
include( base_path().'/Modules/funciones_varias.php');

class PagoEmpleadoController extends AdminBaseController
{
    /**
     * @var PagoEmpleadoRepository
     */
    private $pagoempleado;

    private $auth;

    public function __construct(PagoEmpleadoRepository $pagoempleado, Authentication $auth )
    {
        parent::__construct();

        $this->auth=$auth;

        $this->pagoempleado = $pagoempleado;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
       
        return view('empleados::admin.pagoempleados.index');
    }

    public function indexAjax(Request $request)
    {
        //dd($request->all());
        $query = PagoEmpleado::join('empleados__empleados','empleados__empleados.id','=','empleado_id')
                ->join('users','users.id','=','usuario_sistema_id')
                ->select([
                    'empleados__pagoempleados.id as id',
                    'empleados__pagoempleados.anulado as anulado',
                    'empleados__pagoempleados.fecha as fecha',
                    'empleados__empleados.nombre as nombre',
                    'empleados__empleados.apellido as apellido',
                   DB::raw('CONCAT(users.last_name," ",users.first_name) as usuario')
                   ])
                ->orderBy('empleados__pagoempleados.fecha','desc');
        
       // dd( $query->toSql() );

        $object = Datatables::of( $query )
                ->addColumn('accion', function ($tabla)  
                { 
                $asEdit = "admin.empleados.pagoempleado.edit"; 
 
                $editRoute = route( $asEdit, [$tabla->id]); 
 
                $buttons="<div class='btn-group'> 

                            <a href='". $editRoute." ' class='btn btn-default btn-flat'> 
                                <b>DETALLES</b></i> 
                            </a>";
               
                        $buttons .= "</div>"; 
 
                return $buttons; 
            }) 
            ->editColumn('fecha', function($tabla)
            {
                return date_from_server($tabla->fecha);
            })
            ->editColumn('anulado', function($tabla)
            {
                return $tabla->anulado?"SI":"NO";
            })
            ->filter(function ($query) use ($request) 
            {
                $query->where('anulado', $request->get('anulado'));

                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') ) 
                    $query->where('empleados__pagoempleados.fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') ) 
                    $query->where('empleados__pagoempleados.fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
            
                if ($request->has('empleado')  && trim($request->has('empleado') !== '') )
                    $query->where('nombre', 'like', "%{$request->get('empleado')}%");

            })
            ->make(true);

          
       
        return $object;
    }



    public function seleccionEmpleado()
    {
        $empleados=Empleado::get();
        
        return view('empleados::admin.pagoempleados.seleccionEmpleado',compact('empleados') );
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Empleado $empleado)
    {
        // dd($empleado->pagoempleado);
        // dd(Asiento::get());
        $userID = $this->auth->id();

        $fecha = date('d/m/Y');

        $usuario = DB::table('users')->where('id',$userID)->first();
        $fecha = (object)['fecha' => $fecha];
       
        return view('empleados::admin.pagoempleados.create',compact('empleado','usuario','fecha'));
        
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd( $request->anticipo );
        if( $request->has('anticipo') )
            $ids_anticipos = collect($request->anticipo)->keys();
        else
            $ids_anticipos = [];
        $suma_anticipos = 0;
        $anticipos = array();
        foreach ($ids_anticipos as $key => $id)
        {
            $anticipo = \Anticipo::find($id);
            $anticipos[] = $anticipo;
            $suma_anticipos += (int)$anticipo->unformated('monto');
        }

        $request['fecha'] = \Carbon::createFromFormat('d/m/Y', $request['fecha'])->format('Y-m-d');

        $request['salario'] = intval( str_replace('.', '', $request['salario']) );

        $request['monto_ips'] = (int)str_replace('.', '', $request['monto_ips']);

        $request['extra'] = (int)str_replace('.', '', $request['extra']);

        $request['total_pagar'] = (int)str_replace('.', '', $request['total_pagar']);

        DB::beginTransaction();

        try
        {

            $empleado = Empleado::where('id', $request['empleado_id'])->first();

            $pago_empleado = PagoEmpleado::create
            ([
                'salario' => $request['salario'],
                'monto_ips' => $request['monto_ips'],
                'extra' => $request['extra'],
                'total' => $request['total_pagar'],
                'fecha' => $request['fecha'],
                'observacion' => $request['observacion'],
                'empleado_id' => $request['empleado_id'],
                'usuario_sistema_id' => $this->auth->id()
            ]);

            $asiento = Asiento::create
            ([
                'fecha' => get_actual_date_server(),
                'operacion' => 'Pago de Salario',
                'observacion' => 'Pago de Salario  |  Empleado: '.$empleado->nombre,
                'usuario_create_id' => $this->auth->id(),
                'entidad_id' => $pago_empleado->id,
                'entidad_type' => PagoEmpleado::class
            ]);

            $salario = $request['salario'];

            $extra = $request['extra'];

            if($empleado->ips && $salario>0)
                $sueldo_monto = ($salario*0.91)+$extra;
            else
                $sueldo_monto = $salario+$extra;

            $sueldos_jornales = AsientoDetalle::create
            ([
                'asiento_id' => $asiento->id,
                'cuenta_id' => \CuentasFijas::get('pagoempleado.sueldojornales.debe')->id,//SUELDOS Y JORNALES
                'debe' => $sueldo_monto,
                'haber' => 0
            ]);

            if($empleado->ips && $salario>0)
            {
                $aporte_patronal = AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('pagoempleado.aportepatronal.debe')->id,//Aporte Patronal
                    'debe' => $salario*0.165,
                    'haber' => 0
                ]);

                $ips = AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('pagoempleado.ips.debe')->id,//IPS o seguros pagados
                    'debe' => $salario*0.09,
                    'haber' => 0
                ]);

                $ips_aporte_patronal = AsientoDetalle::create
                ([
                    'asiento_id' => $asiento->id,
                    'cuenta_id' => \CuentasFijas::get('pagoempleado.aporte_patronal_ips.haber')->id,//IPS Y APORTE PATRONAL A PAGAR //Obligaciones Laborales Y Cargas Sociales
                    'debe' => 0,
                    'haber' => $aporte_patronal->debe + $ips->debe
                ]);
            }

            $caja = AsientoDetalle::create
            ([
                'asiento_id' => $asiento->id,
                'cuenta_id' => \CuentasFijas::get('pagoempleado.caja.haber')->id,//CAJA
                'debe' => 0,
                'haber' => $sueldo_monto - $suma_anticipos
            ]);

            foreach ($anticipos as $key => $anticipo) 
            {
                $anticipo->descontado = true;
                $anticipo->pago_empleado_id = $pago_empleado->id;
                $anticipo->save();
            }

            if($suma_anticipos>0)
            {
                $asiento_detalle = new \AsientoDetalle();
                $asiento_detalle->asiento_id = $asiento->id;
                $asiento_detalle->cuenta_id = \CuentasFijas::get('empleados.pago_empleado.pago_empleado_store.anticipo_de_salario.haber')->id;
                $asiento_detalle->debe = 0;
                $asiento_detalle->haber = $suma_anticipos;
                $asiento_detalle->save();
            }
            

        }
        catch(Exception $e)
        {
            DB::rollBack();

            flash()->error( $e );

            return redirect()->back();
        }

        DB::commit();


        flash()->success( 'Pago de empleado creado correctamente' );

        return redirect()->route('admin.empleados.pagoempleado.index');
/*
        if(isset($asiento))
            return redirect()->route('admin.contabilidad.asiento.edit', $asiento->id);
*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PagoEmpleado $pagoempleado
     * @return Response
     */
    public function edit(PagoEmpleado $pagoempleado, Request $re)
    {
        $anticipos = \Anticipo::select('id', 'fecha', 'monto', 'observacion' )->where('pago_empleado_id', $pagoempleado->id)->get();
        $pagoempleado->fecha = date_from_server( $pagoempleado->fecha );
        
        return view('empleados::admin.pagoempleados.edit', compact('pagoempleado','anticipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PagoEmpleado $pagoempleado
     * @param  Request $request
     * @return Response
     */
    public function update(PagoEmpleado $pagoempleado, Request $request)
    {
       dd("acces denied");

        $fecha = $request['fecha'];

        $date =  date("Y-m-d", strtotime( str_replace('/', '-', $fecha) ));

        $fecha = $date->format('d-m-Y');

        $empleado_id = (int)str_replace('.', '', $request['empleado_id']);

        PagoEmpleado::where('empleado_id',$empleado_id)
                    ->update
                    ([  
                        'salario' => (int)str_replace('.', '', $request['salario']),
                        'monto_ips' => (int)str_replace('.', '', $request['monto_ips']),
                        'extra' => (int)str_replace('.', '', $request['extra']),
                        'total' => (int)str_replace('.', '', $request['total_pagar']),
                        'fecha' => $date->format('Y-m-d'),
                        'observacion' => $request['observacion'],
                        'empleado_id' => $request['empleado_id'],
                        'usuario_sistema_id' => $request['usuario_sistema_id']
                    ]);


        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('empleados::pagoempleados.title.pagoempleados')]));

        return redirect()->route('admin.empleados.pagoempleado.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PagoEmpleado $pagoempleado
     * @return Response
     */
    public function destroy(PagoEmpleado $pagoempleado)
    {
        dd("acces denied");
        $this->pagoempleado->destroy($pagoempleado);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('empleados::pagoempleados.title.pagoempleados')]));

        return redirect()->route('admin.empleados.pagoempleado.index');
    }




    public function anular_asientos(PagoEmpleado $pago, Request $re)
    {
        $pago->anulado = true;
        $pago->save();

        foreach ($pago->asientos as $key => $asiento) 
            $asiento->generar_contraasiento( $re->user()->id );

        foreach ($pago->anticipos as $key => $anticipo) 
        {
            $anticipo->descontado = false;
            $anticipo->pago_empleado_id = null;
            $anticipo->save();
        }
        flash()->success("Pago anulado correctamente");
        return redirect()->route('admin.empleados.pagoempleado.index');
        //return redirect()->route('admin.contabilidad.asiento.edit', \Asiento::select('id')->orderBy('id', "DESC")->first()->id);
    }









}
