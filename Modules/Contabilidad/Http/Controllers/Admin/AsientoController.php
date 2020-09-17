<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\AsientoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
use DB;
use Carbon\Carbon;
use Modules\Contabilidad\Entities\AsientoDetalle;
use DateTime;
use Modules\Core\Contracts\Authentication;

class AsientoController extends AdminBaseController
{
    /**
     * @var AsientoRepository
     */
    private $asiento;

    public function __construct(AsientoRepository $asiento)
    {
        parent::__construct();

        $this->asiento = $asiento;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $asientos = $this->asiento->all();

        //dd($asientos);

        return view('contabilidad::admin.asientos.index', compact('asientos'));
    }

    public function index_ajax_asientos(Request $request)
    {
        //dd($request->all());
        $query = Asiento::leftjoin('users','users.id', '=', 'contabilidad__asientos.usuario_create_id')
        ->leftjoin('users as users2','users2.id', '=', 'contabilidad__asientos.usuario_edit_id')
        ->orderBy('fecha','DESC')
        ->select([
            'contabilidad__asientos.id as id',
            'fecha',
            'observacion',
            'operacion',
            DB::raw('CONCAT(users.last_name," ",users.first_name) as usuario_create'),
            DB::raw('CONCAT(users2.last_name," ",users2.first_name) as usuario_edit')
            ]);
       
        $object = Datatables::of( $query )

            ->addColumn('action', function ($tabla) 
            {
                $base_path = 'admin.contabilidad.asiento.';

                $asEdit = $base_path."edit";

                $asDestroy = $base_path."destroy";

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $buttons="<div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                <b>DETALLES</b>
                            </a>
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </div>";

                return $buttons;
            })

            ->filter(function ($query) use ($request)
            {
                //dd($request->all());
                
                if ($request->has('observacion')  && trim($request->has('observacion') !== '') )
                {

                    $query->where('contabilidad__asientos.observacion', 'like',"%{$request->get('observacion')}%");

                }
                if ($request->has('operacion')  && trim($request->has('operacion') !== '') )
                {

                    $query->where('operacion', 'like',"%{$request->get('operacion')}%");

                }
                if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') != '') )
                {
                    $query->where('fecha', '>', date_create_from_format('d/m/Y', $request->get('fecha_inicio'))->modify('-1 day')  );
                }

                if ($request->has('fecha_fin') && trim($request->has('fecha_fin') != '') )
                {
                    $query->where('fecha', '<', date_create_from_format('d/m/Y', $request->get('fecha_fin'))  );
                }

            })
             ->editColumn('fecha', function($tabla)
            {
                return date("d/m/Y", strtotime($tabla->fecha));
            })

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
        $now = Carbon::now('America/Asuncion')->format('d/m/Y');

        //dd($now);

        return view('contabilidad::admin.asientos.create',compact('now'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Authentication $usuario)
    {
        //dd( $request->all() );
/*----------header*/
        $fecha = $request->get('fecha');

        $observacion = $request->get('observacion');
/*----------details*/
        $cuenta_id = $request->get('cuenta_id');

        $observacion_detalle = $request->get('observacion_detalle');

        $debe = $request->get('debe');

        $haber = $request->get('haber');

        /*
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        if( $validator->fails() )
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        */

        DB::beginTransaction();

        try
        {

            $asiento = Asiento::create
            ([
                'fecha'=>Carbon::createFromFormat('d/m/Y', $fecha),
                'operacion' => $request['operacion'],
                'observacion'=>$observacion,
                'usuario_create_id' => $usuario->id()
            ]);

            for($i = 0; $i < count($cuenta_id); $i++)
            {
                AsientoDetalle::create
                ([
                    'asiento_id'=>$asiento->id,
                    'cuenta_id'=>$cuenta_id[$i],
                    'debe'=>str_replace('.', '', $debe[$i]),
                    'haber'=>str_replace('.', '', $haber[$i]),
                    'observacion'=>$observacion_detalle[$i]
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

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('contabilidad::asientos.title.asientos')]));

        return redirect()->route('admin.contabilidad.asiento.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Asiento $asiento
     * @return Response
     */
    public function edit(Asiento $asiento)
    {
        $detalles = AsientoDetalle::where('asiento_id',$asiento->id)->get();

        $asiento->fecha = new DateTime($asiento->fecha);
        
        $asiento->fecha = $asiento->fecha->format('d-m-Y');

        $url_factura = '';
        //dd("here");
        return view('contabilidad::admin.asientos.edit', compact('asiento','detalles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Asiento $asiento
     * @param  Request $request
     * @return Response
     */
    public function update(Asiento $asiento, Request $request, Authentication $usuario)
    {
        $asiento_fecha = $request->get('fecha');
        $asiento_observacion =$request->get('observacion');

        $asiento_id = $asiento->id;
        $cuenta_id = $request->get('cuenta_id');
        $debe = $request->get('debe');
        $haber = $request->get('haber');
        $observacion_detalle = $request->get('observacion_detalle');
        $detalle_id = $request->get('detalle_id'); 
        $eliminar_id = $request->get('eliminar'); 
        //dd($request->all());

        DB::beginTransaction();

        try
        {
           Asiento::where('id',$asiento_id)
            ->update
            ([
                'fecha'=> Carbon::createFromFormat('d/m/Y', $asiento_fecha),
                'observacion'=> $asiento_observacion,
                'operacion' => $request['operacion'],
                'usuario_edit_id' => $usuario->id()

            ]);

            for($i = 0; $i < count($detalle_id); $i++)
            {
                if($eliminar_id[$i]==1)
                {
                    AsientoDetalle::where('id',$detalle_id[$i])->delete();
                }

                else
                {    
                    if($detalle_id[$i]>0)
                    {
                        AsientoDetalle::where('id',$detalle_id[$i])
                        ->update
                        ([
                            'asiento_id'=>$asiento_id,
                            'cuenta_id'=>$cuenta_id[$i], 
                            'debe'=>str_replace('.', '', $debe[$i]),
                            'haber'=>str_replace('.', '', $haber[$i]),
                            'observacion'=>$observacion_detalle[$i]
                        ]);
                            
                    }
                    else
                    {    
                        AsientoDetalle::insert([
                                    'asiento_id'=>$asiento_id,
                                    'cuenta_id'=>$cuenta_id[$i], 
                                    'debe'=>str_replace('.', '', $debe[$i]),
                                    'haber'=>str_replace('.', '', $haber[$i]),
                                    'observacion'=>$observacion_detalle[$i]
                                ]);
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

        

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('contabilidad::asientos.title.asientos')]));

        return redirect()->route('admin.contabilidad.asiento.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Asiento $asiento
     * @return Response
     */
    public function destroy(Asiento $asiento)
    {
        if($asiento->entidad_id)
        {
            flash()->error('El asiento ya esta relacionado con una compra o venta');

            return redirect()->back();
        }

        $this->asiento->destroy($asiento);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::asientos.title.asientos')]));

        return redirect()->route('admin.contabilidad.asiento.index');
    }

    public function anular(Asiento $asiento, Authentication $usuario)
    {
        DB::beginTransaction();

        try
        {
            $asiento_nuevo = new Asiento;

                $asiento_nuevo->fecha = date('Y-m-d');

                $asiento_nuevo->operacion = "Anulacion de " . $asiento->operacion;;

                $asiento_nuevo->observacion = $asiento->observacion;

                $asiento_nuevo->usuario_create_id = $usuario->id();

                $asiento_nuevo->entidad_id = $asiento->entidad_id;

                $asiento_nuevo->entidad_type = $asiento->entidad_type;

            $asiento_nuevo->save();

            foreach ($asiento->detalles as $key => $detalle) 
            {
                $detalle_nuevo = new AsientoDetalle;

                    $detalle_nuevo->asiento_id = $asiento_nuevo->id;

                    $detalle_nuevo->cuenta_id = $detalle->cuenta_id;

                    $detalle_nuevo->debe = $detalle->haber;

                    $detalle_nuevo->haber = $detalle->debe;

                    $detalle_nuevo->observacion = '';

                $detalle_nuevo->save();
            }   

        }

        catch (ValidationException $e)
        {
            DB::rollBack();

            flash()->success('Ocurrio un error al anular.');

            return redirect()->back();
        }

        DB::commit();

        flash()->success('Contra-asiento generado correctamente.');

        return redirect()->route('admin.contabilidad.asiento.edit', [$asiento_nuevo->id]);
    }
}
