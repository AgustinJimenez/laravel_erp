<?php namespace Modules\Caja\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Caja\Entities\Caja;
use Modules\Caja\Repositories\CajaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
include( base_path().'/Modules/funciones_varias.php');
use Modules\Caja\Http\Requests\CajaRequest;
use Modules\Core\Contracts\Authentication;
use Yajra\Datatables\Facades\Datatables;
use DB;
use DateTime;
use Modules\Pagofacturascredito\Entities\Pagofacturacredito;
use Dompdf\Dompdf;
use App;
use PDF;
use Modules\Caja\Entities\CajaMovimiento;
use Modules\Contabilidad\Entities\Cuenta;

class CajaController extends AdminBaseController
{
    /**
     * @var CajaRepository
     */
    private $caja;

    private $usuario;

    public function __construct(CajaRepository $caja, Authentication $usuario)
    {
        parent::__construct();

        $this->caja = $caja;

        $this->usuario = $usuario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('caja::admin.cajas.index');
    }

    public function index_ajax(Request $request)
    {
        $query = Caja::join('users','users.id','=','caja_cajas.usuario_sistema_id')
        ->orderBy('caja_cajas.cierre','desc')
        ->select([
                    'caja_cajas.id', 
                    'caja_cajas.created_at as created_at',
                    'cierre', 
                    DB::raw('CONCAT(users.last_name," ",users.first_name) as usuario'),
                    'monto_inicial',
                    'activo'
                ]);

        //dd( $query->get() );

        $columns = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $base_path = "admin.caja.caja";

                $asEdit = $base_path.".edit";

                $asDestroy = $base_path.".destroy";

                $asPdf = $base_path.".pdf";

                $as_movimientos = $base_path.'.index_movimientos';

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $pdfRoute = route( $asPdf, [$tabla->id]);

                $movimientos_route = route($as_movimientos, [$tabla->id]);

                $buttons="<center><div class='btn-group '>
                            <a href='".$pdfRoute." ' class='btn btn-default btn-flat' target='_blank'>
                                <strong>Resumen</strong>
                            </a>";

                if(count($tabla->movimientos)>0)
                {

                $buttons=$buttons."<a href='".$movimientos_route." ' class='btn btn-default btn-flat'>
                                <strong>Otros Movimientos</strong>
                                    </a>";

                }
                            if($tabla->cierre == '0000-00-00 00:00:00')
                            {
                                $buttons=$buttons."<a href='".$editRoute." ' class='btn btn-primary btn-flat'>
                                <b>Cerrar Caja</b>
                                    </a>";
                            }
                            /*
                            $buttons=$buttons."<button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute ."'>
                                <i class='fa fa-trash'></i>
                                </button>";
                                */
                        $buttons=$buttons."</div><center>";

                return $buttons;
            })
            ->filter(function ($query) use ($request)
            {
                if ($request->has('usuario')  && trim($request->has('usuario') !== '') )
                {
                    $query->where('users.first_name', 'like', "%{$request->get('usuario')}%");
                }

                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') != '') )
                {
                    $query->where('caja_cajas.created_at', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
                }

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') != '') )
                {
                    $query->where('caja_cajas.created_at', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                }

                if ($request->has('activo')  && trim($request->has('activo') !== '') )
                {
                    $query->where('activo',$request->get('activo') );
                }
            })
            ->editColumn('activo',' @if($activo)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->editColumn('created_at', function($tabla)
            {
                
                return DateTime::createFromFormat('Y-m-d H:i:s', $tabla->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('cierre', function($tabla)
            {
                if($tabla->cierre == '0000-00-00 00:00:00')
                    return '';
                else
                    return DateTime::createFromFormat('Y-m-d H:i:s', $tabla->cierre)->format('d/m/Y H:i:s');
            })
            ->editColumn('monto_inicial', function($tabla)
            {
                return number_format($tabla->monto_inicial, 0, '', '.');
            })
            ->make(true);

        return $columns;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hay_activo = Caja::where('activo', true)->first();

        if($hay_activo)
        {
            flash()->error('Ya hay una caja activa.');

            return redirect()->back();
        }

        return view('caja::admin.cajas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CajaRequest $req, Authentication $user)
    {
        //dd( $req->all() );
        $req['created_at'] = get_actual_date_time_server();
        
        $hay_activo = Caja::where('activo', true)->first();

        if($hay_activo)
        {
            flash()->error('Ya hay una caja activa.');

            return redirect()->back();
        }
        else
        {
            $this->caja
            ->create
            ([
                'usuario_sistema_id' => $user->id(),
                'monto_inicial' => $req['monto_inicial'],
                'activo' => true
            ]);

            flash()->success(trans('core::core.messages.resource created', ['name' => trans('caja::cajas.title.cajas')]));

            return redirect()->route('admin.caja.caja.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Caja $caja
     * @return Response
     */
    public function edit(Caja $caja)
    {
        $hay_activo = Caja::where('activo', true)->first();

        if($hay_activo && $caja->id != $hay_activo->id)
        {
            flash()->error('Ya hay una caja activa.');

            return redirect()->back();
        }

        $is_edit = 1;

        return view('caja::admin.cajas.edit', compact('caja','is_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Caja $caja
     * @param  Request $request
     * @return Response
     */
    public function update(Caja $caja, CajaRequest $req)
    {
        if($req['activo'] == false && $caja->cierre == '0000-00-00 00:00:00')
            $req['cierre'] = get_actual_date_time_server();

        $this->caja->update($caja, $req->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('caja::cajas.title.cajas')]));

        return redirect()->route('admin.caja.caja.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Caja $caja
     * @return Response
     */
    public function destroy(Caja $caja)
    {
        $this->caja->destroy($caja);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('caja::cajas.title.cajas')]));

        return redirect()->route('admin.caja.caja.index');
    }

    public function pdf(Caja $caja)
    {
        $view = view('caja::admin.cajas.pdf', compact('caja','pagos'));

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif', 'isPhpEnabled' => true, 'isJavascriptEnabled' => true, 'debugCss' => false])
            ->loadHTML($view)
            ->setPaper("legal", "portrait")
            //->save('caja_documento.pdf')
            ->stream('caja', array("Attachment" => 0));//0 preview/ 1 download

        return $pdf;
    }
    

    public function index_movimientos_activo()
    {
        $caja = Caja::where('activo', true)->first();

        if(!$caja)
        {

            flash()->error('Para poder acceder a los movimientos de Caja, debe estar Activa.');

            return redirect()->route('admin.caja.caja.index');
        }

        return view('caja::admin.movimientos.index', compact('caja'));
    }

    public function index_movimientos(Caja $caja)
    {
        return view('caja::admin.movimientos.index', compact('caja'));
    }

    public function create_movimiento()
    {
        $caja = Caja::where('activo', true)->first();

        if(!$caja)
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        return view('caja::admin.movimientos.create');
    }

    public function store_movimiento(Request $re)
    {
        $caja = Caja::where('activo', true)->first();

        if(!$caja)
        {

            flash()->error('Debe haber una caja activa, cree una.');

            return redirect()->route('admin.caja.caja.index');
        }

        $re['monto'] = remove_dots($re['monto']);

        if($re['tipo'] == 'extraccion')
            $re['monto'] = $re['monto']*-1;

        $re['fecha_hora'] = get_actual_date_time_server();

        $re['usuario_sistema_id'] = $this->usuario->id();

        $re['caja_id'] = $caja->id;

        CajaMovimiento::create($re->all());

        return redirect()->route('admin.caja.caja.index_movimientos', compact('caja'));
    }

    public function update_movimiento()
    {
        dd('here');
    }


    
}
