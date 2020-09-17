<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\CuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Http\Requests\CuentaRequest;
use Modules\Contabilidad\Entities\TipoCuenta;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Yajra\Datatables\Facades\Datatables;
use Response;
use DB, Session, Carbon\Carbon;
include( base_path().'/Modules/funciones_varias.php');
use Maatwebsite\Excel\Facades\Excel;

class CuentaController extends AdminBaseController
{
    /**
     * @var CuentaRepository
     */
    private $cuenta;

    public function __construct(CuentaRepository $cuenta)
    {
        parent::__construct();

        $this->cuenta = $cuenta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cuentas = $this->cuenta->all();

        $tipos = TipoCuenta::orderBy('id')->get(['nombre','id']);

        return view('contabilidad::admin.cuentas.index', compact('cuentas','tipos'));
    }
    
    public function index_ajax_filter(Request $request)
    {
        //dd($request->all());
        $query = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')

                ->select([
                            'contabilidad__cuentas.id as id', 

                            'contabilidad__cuentas.codigo', //codigo

                            'tipo_cuentas.nombre as tipo_nombre', //tipo

                            'contabilidad__cuentas.nombre',//nombre 

                            'cuenta_padre.nombre as padre',//padre

                            'contabilidad__cuentas.tiene_hijo as tiene_hijo',
                         
                            'contabilidad__cuentas.activo as activo'
                        ]);

        $object = Datatables::of( $query )
            
            ->addColumn('action', function ($tabla) 
            {
                $asEdit = "admin.contabilidad.cuenta.edit";
                $asDestroy = "admin.contabilidad.cuenta.destroy";
                $editRoute = route( $asEdit, [$tabla->id]);
                $id_cuenta = AsientoDetalle::where('cuenta_id',$tabla->id)->get()->first();
                $deleteRoute = route( $asDestroy, [$tabla->id]);
                //dd($id_cuenta);

                if ($tabla->tiene_hijo==1 || $id_cuenta != null ) 
                {
                    $buttons="<div class='btn-group'>
                            <a href='". $editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                           
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-cuenta' id=".'delete'." value=".$tabla->id." data-action-target='". $deleteRoute ."'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </div>";
                    
                }
                else
                {
                    $buttons="<div class='btn-group'>
                        <a href='". $editRoute." ' class='btn btn-default btn-flat'>
                            <i class='fa fa-pencil'></i>
                        </a>
                       
                        <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' id=".'delete'." value=".$tabla->id." data-action-target='". $deleteRoute ."'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </div>";
                }

             

                return $buttons;
            })

       
            ->filter(function ($query) use ($request)
            {


                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') )
                {
                    $query->where('fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day'));
                }

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') )
                {
                    $query->where('fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                }

                if ($request->has('codigo')  && trim($request->has('codigo') !== '') )
                {

                    $query->where('contabilidad__cuentas.codigo', 'like', "%{$request->get('codigo')}%");

                }

                if ($request->has('tipo_nombre')  && trim($request->has('tipo_nombre') !== '') )
                {

                    $query->where('tipo_cuentas.nombre', '=', $request->get('tipo_nombre'));

                }

                if ($request->has('nombre')  && trim($request->has('nombre') !== '') )
                {

                    $query->where('contabilidad__cuentas.nombre', 'like', "%{$request->get('nombre')}%");

                }

                if ($request->has('padre')  && trim($request->has('padre') !== '') )
                {

                    $query->where('cuenta_padre.nombre', 'like', "%{$request->get('padre')}%");

                }

                if ($request->has('tiene_hijo')  && trim($request->has('tiene_hijo') !== '') )
                {

                    $query->where('contabilidad__cuentas.tiene_hijo', '=', $request->get('tiene_hijo'));

                }

                if ($request->has('activo')  && trim($request->has('activo') !== '') )
                {

                    $query->where('contabilidad__cuentas.activo', '=', $request->get('activo'));

                }

            })
            ->editColumn('activo',' @if($activo)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->editColumn('tiene_hijo',' @if($tiene_hijo)
                                        <?php echo "<b>Si</b>"; ?>
                                             
                                        @else
                                            NO
                                        @endif')

            ->editColumn('codigo',' @if($tiene_hijo==1)
                                        <?php echo "<b>$codigo</b>"; ?>
                                             
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->make( true );

            
        return $object; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tipos = TipoCuenta::orderBy('id')->get(['nombre','id']);

        $cuentas = Cuenta::with('tipo_nombre')->where('tiene_hijo',true)->orderBy('codigo')->get(/*['id','nombre']*/);

        $cuentas_fijas = \CuentasFijas::get();
        //dd( $cuentas_fijas );

        return view('contabilidad::admin.cuentas.create',compact('tipos','cuentas'));
    }

    public function cuenta_exist(Request $re)
    {
        if(!$re['codigo'])
            return 0;

        $exist_cuenta = Cuenta::where( 'codigo', $re['codigo'] )->count();

            if($exist_cuenta && $re['codigo'] == $re['codigo_edit'])
                $exist_cuenta = 0;

        if($exist_cuenta)
            return 1;
        else
            return 0;
    }

    public function search_padre( Request $request )
    {
        $results = array();

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Cuenta::where('tiene_hijo',true)
                                ->where('nombre', 'like', "%{$request->get('term')}%")
                                ->take(7)
                                //->orderBy('nombre_apellido')
                                ->get(['id','nombre']);
            
        }
    
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->nombre];
        }

    return Response::json($results);
    }

    
//Controlador de vista Libro Mayor


    public function search_cuenta_asiento( Request $request )
    {
        $results = array();

        //dd( $request->all() );

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Cuenta::where('tiene_hijo',0)
                        ->where(DB::raw('CONCAT(codigo," ",nombre)'), 'like', "%{$request->get('term')}%")
                        ->take(7)
                        ->select(
                                'id',
                                'nombre',
                                'codigo',
                                DB::raw('CONCAT(codigo," -",nombre) as codigo_nombre') )
                        ->get();  
        }
    
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->codigo_nombre, 'nombre' => $query->nombre];
        }
        //dd($results);
        return Response::json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CuentaRequest $re)
    {
        $re['codigo'] = $re['codigo_real'];
        if(Cuenta::where('codigo', $re['codigo'])->count())
        {
            flash()->error( "La cuenta ya existe." );
            return redirect()->back();
        }
        $profundidad = explode(".",$re['codigo']);
        $re['profundidad'] = count($profundidad);
        $cuenta_nueva = new Cuenta;
            $cuenta_nueva->codigo = $re['codigo'];
            $cuenta_nueva->nombre = $re['nombre'];
            $cuenta_nueva->padre = (int)$re['padre'];
            $cuenta_nueva->tiene_hijo = (int)$re['tiene_hijo'];
            $cuenta_nueva->activo = (int)$re['activo'];
            $cuenta_nueva->tipo = (int)$re['tipo'];
            $cuenta_nueva->profundidad = $re['profundidad'];
            DB::beginTransaction();
            try
            {
                $cuenta_nueva->save();
            }
            catch (ValidationException $e)
            {
                DB::rollBack();
                flash()->error( "Ocurrio un error al intentar crear la cuenta." );
                return redirect()->back();
            }
            DB::commit();       
        flash()->success( "Cuenta Creada Correctamente" );
        return redirect()->route('admin.contabilidad.cuenta.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cuenta $cuenta
     * @return Response
     */
    public function edit(Cuenta $cuenta)
    {
        $tipos = TipoCuenta::orderBy('id')->get(['nombre','id']);
        $cuentas = Cuenta::with('tipo_nombre')->with('padre_nombre')->where('tiene_hijo',true)->orderBy('codigo')->get();
        $tiene_hijo = Cuenta::where('padre',$cuenta->id)->get()->all();
        $sin_hijo = 0;
        if ($tiene_hijo == null) 
            return view('contabilidad::admin.cuentas.edit', compact('cuenta','cuentas','tipos','sin_hijo', 'relacion_cuentas_fijas'));
        else
            return view('contabilidad::admin.cuentas.edit', compact('cuenta','cuentas','tipos','tiene_hijo', 'relacion_cuentas_fijas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Cuenta $cuenta
     * @param  Request $request
     * @return Response
     */
    public function update(Cuenta $cuenta, CuentaRequest $re)
    {
        $re['codigo'] = $re['codigo_real'];
        $profundidad = explode(".",$re['codigo']);
        $re['profundidad'] = count($profundidad);
        if($re['codigo_real'][0] == ".")//fix si el primer character es .
            $re['codigo_real'] = substr( $re['codigo_real'], 1);
        if( $re->has('codigo_real') )
            $cuenta->codigo = $re['codigo_real'];
        if( $re->has('nombre') )
            $cuenta->nombre = $re['nombre'];
        if( $re->has('padre') )
            $cuenta->padre = (int)$re['padre'];
        if( $re->has('tiene_hijo_aux') )
            $cuenta->tiene_hijo = (int)$re['tiene_hijo_aux'];
        if( $re->has('activo') )
            $cuenta->activo = (int)$re['activo'];
        if( $re->has('tipo') )
            $cuenta->tipo = (int)$re['tipo'];
        if( $re->has('profundidad') )
            $cuenta->profundidad = $re['profundidad'];
        
        DB::beginTransaction();
        try
        {
            $cuenta->save();
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error( "Ocurrio un error al intentar actualizar la cuenta." );
            return redirect()->back();
        }
        DB::commit(); 
        flash()->success("Cuenta actualizada correctamente");
        return redirect()->route('admin.contabilidad.cuenta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cuenta $cuenta
     * @return Response
     */
    public function destroy(Cuenta $cuenta)
    {
        //dd($cuenta);
        $this->cuenta->destroy($cuenta);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::cuentas.title.cuentas')]));

        return redirect()->route('admin.contabilidad.cuenta.index');
    }

    public function historial(Cuenta $cuenta, Request $re)
    {
        if( $re->user()->get_full_permisos->get('contabilidad.cuentas')['historial-solo-caja-ita'] )
            $cuenta = \Cuenta::where('codigo', '01.01.01.02.01')->first();

           // dd( $re->all() );
        if($re->has('fecha_inicio_historial'))
        {
            $re['fecha_inicio_historial_format'] = $re['fecha_inicio_historial'];
            $re['fecha_inicio_historial'] = Carbon::createFromFormat('d/m/Y', $re['fecha_inicio_historial'])->format('Y-m-d');
        }
        else
        {
            $re['fecha_inicio_historial'] = (new Carbon('first day of this month'))->format('Y-m-d');
            $re['fecha_inicio_historial_format'] = Carbon::createFromFormat('Y-m-d', $re['fecha_inicio_historial'])->format('d/m/Y');
        }

        if($re->has('fecha_fin_historial'))
        {
            $re['fecha_fin_historial_format'] = $re['fecha_fin_historial'];
            $re['fecha_fin_historial'] = Carbon::createFromFormat('d/m/Y', $re['fecha_fin_historial'])->format('Y-m-d');
        }
        else
        {
            $re['fecha_fin_historial'] = date('Y-m-d');
            $re['fecha_fin_historial_format'] = date('d/m/Y');
        }
            

        $saldo_acumulado = $cuenta->totalEjercicioContable( $re['fecha_inicio_historial'] , $re['fecha_fin_historial'] )->saldo;

        $saldo_acumulado  = thousands_separator_dots($saldo_acumulado);

        return view('contabilidad::admin.historial-cuentas.index', [
                                                                    'saldo_acumulado' => $saldo_acumulado, 
                                                                    'cuenta' => $cuenta, 
                                                                    'fecha_inicio' => $re['fecha_inicio_historial_format'], 
                                                                    'fecha_fin' => $re['fecha_fin_historial_format'
                                                                    ]]);
    }

    public function historial_ajax(Request $re)
    {
        $year = date('Y', strtotime($re['fecha_inicio']));

        $fecha_inicio_anio = $year.'-01-01';

        $cuenta_id = $re['cuenta_id'];

        $fecha_inicio_filters = date_create_from_format('Y-m-d', date_to_server($re['fecha_inicio']))->modify('-1 day')->format('Y-m-d');

        $saldo_acumulado = Cuenta::where('id', $cuenta_id)->first()->totalEjercicioContable($fecha_inicio_anio, $fecha_inicio_filters)->saldo;

        $array_tmp = $this->query_historial_cuenta($re, $saldo_acumulado);
 
        $query = $array_tmp['query'];

        $query_clone = $array_tmp['query_clone'];    

        $object = Datatables::of( $query )
            ->editColumn('fecha', function($tabla)
            {
                return date("d/m/Y", strtotime($tabla->asiento->fecha));
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
            ->addColumn('saldo', function ($tabla) use ($query_clone)
            {   
                $cuenta = $query_clone->where('id', $tabla->id)->first();

                return thousands_separator_dots($cuenta->saldo_acumulado);
            })
            ->make( true );

        $data = $object->getData(true);

        $data['saldo_acumulado'] = thousands_separator_dots($saldo_acumulado);
        
        $fecha_inicio_menos_uno_format = date_to_server($re['fecha_inicio']);

        $fecha_inicio_menos_uno_format = date_create_from_format("Y-m-d", $fecha_inicio_menos_uno_format)->modify('-1 day')->format('d/m/Y');

        //dd($fecha_inicio_menos_uno_format);
        
        $data['fecha_inicio'] = $fecha_inicio_menos_uno_format;

        return response()->json( $data );

        return $object; 
    }

    public function query_historial_cuenta(Request $re, $saldo_acumulado)
    {
        $query = AsientoDetalle::where('cuenta_id', $re['cuenta_id'])
        
                                ->join('contabilidad__asientos', 'contabilidad__asientos.id', '=', 'contabilidad__asientodetalles.asiento_id')
                                ->join('contabilidad__cuentas', 'contabilidad__cuentas.id', '=', 'contabilidad__asientodetalles.cuenta_id')
                                ->join('contabilidad__tipocuentas', 'contabilidad__tipocuentas.id', '=', 'contabilidad__cuentas.tipo')
                                ->select
                                ([
                                    'contabilidad__asientodetalles.*'
                                ])
                                ->orderBy('fecha', 'ASC')->orderBy('id');
        
        if ($re->has('fecha_inicio') && trim($re->has('fecha_inicio') !== '') )
            $query->where('fecha', '>', date_create_from_format('d/m/Y', $re['fecha_inicio'])->modify('-1 day'));
        

        if ($re->has('fecha_fin') && trim($re->has('fecha_fin') !== '') )
            $query->where('fecha', '<', date_create_from_format('d/m/Y', $re['fecha_fin'])  );

        $query_clone = $query->get();
//dd($query_clone);
        foreach ($query_clone as $key => $value) 
        {

            if( $value->naturaleza_cuenta == 'deudor')
            {
                $saldo = $value->debe - $value->haber;
            }
            else
            {
                $saldo = $value->haber - $value->debe;
            }

            $saldo_acumulado += $saldo;

            $value->saldo_acumulado = $saldo_acumulado;

        }

        return ['query' => $query, 'query_clone' => $query_clone];
    }

    public function historial_excel(Request $re)
    {
        $cuenta_id = $re['cuenta_id'];

        $re['fecha_inicio'] = $re['fecha_inicio_excel'];

        $re['fecha_fin'] = $re['fecha_fin_excel'];

        $cuenta = Cuenta::where('id', $re['cuenta_id'])->first();

        $year = date('Y', strtotime(date_to_server($re['fecha_inicio'])));

        $fecha_inicio_anio = $year.'-01-01';

        $fecha_inicio_filters = date_create_from_format('Y-m-d', date_to_server($re['fecha_inicio']))->modify('-1 day')->format('Y-m-d');

        $saldo_acumulado = Cuenta::where('id', $cuenta_id)->first()->totalEjercicioContable($fecha_inicio_anio, $fecha_inicio_filters)->saldo;

        $array_tmp = $this->query_historial_cuenta($re, $saldo_acumulado);

        $query_clone = $array_tmp['query_clone'];

        $registros = collect([]);

        foreach ($query_clone as $key => $registro) 
           $registros[] = 
        [
            'Fecha' =>  date_from_server($registro->asiento->fecha), 
            'Operacion' => $registro->asiento->operacion, 
            'Observación' => $registro->asiento->observacion,
            'Debe' => $registro->debe, 
            'Haber' => $registro->haber, 
            'Saldo' => $registro->saldo_acumulado,
            'Saldo Acumulado hasta el '.$re['fecha_inicio'].' : '.$saldo_acumulado => '' ,
            'Fecha Inicio: '.$re['fecha_inicio'] => '',
            'Fecha Fin: '. $re['fecha_fin'] => '',
            'Cuenta: '.$cuenta->codigo.' '.$cuenta->nombre => '',
            'Fecha de doc: '.date('d/m/Y') => ''
        ];

       $file_name = 'Reporte_de_Cuenta_'.$cuenta->codigo.'_'.$cuenta->nombre.'_'.date('d/m/Y');

        Excel::create($file_name, function($excel) use ($registros) 
        {
            $excel->sheet('Libro Mayor', function($sheet) use ($registros) 
            {
                $sheet->fromArray($registros);
 
            });
        })->export('xls');

    }

    

}
