<?php namespace Modules\Servicios\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Servicios\Http\Requests\ServiciosRequest;
use Modules\Servicios\Entities\Servicio;
use Modules\Servicios\Repositories\ServicioRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
use Response;

class ServicioController extends AdminBaseController
{
    /**
     * @var ServicioRepository
     */
    private $servicio;

    public function __construct(ServicioRepository $servicio)
    {
        parent::__construct();

        $this->servicio = $servicio;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        

        return view('servicios::admin.servicios.index');
    }

    public function search_servicio( Request $request )
    {
        $results = array();

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Servicio::where('activo',true)
                            ->where('nombre', 'like', "%{$request->get('term')}%")
                            ->take(5)
                            //->orderBy('nombre_apellido')
                            ->get(['id','nombre','precio_venta']);
            
        }
    
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->nombre, 'precio' => $query->precio_venta];
        }


        return Response::json($results);
    }

    public function indexAjax()
    {
        $query = Servicio::select(['nombre', 'codigo', 'precio_venta', 'activo','id']);

                
        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.servicios.servicio.edit";

                $asDestroy = "admin.servicios.servicio.destroy";

                $editRoute = route( $asEdit, [$tabla->id] );

                $deleteRoute = route( $asDestroy, [$tabla->id] );

                $buttons="<div class='btn-group'>
                            <a href='".$editRoute."'class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                            <!--
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>
                            -->
                        </div>";

                return $buttons;
            })
            ->editColumn('activo',' @if($activo)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->make();

            //dd( $object );

        return $object;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('servicios::admin.servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(ServiciosRequest $request)
    {
        $this->servicio->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('servicios::servicios.title.servicios')]));

        return redirect()->route('admin.servicios.servicio.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Servicio $servicio
     * @return Response
     */
    public function edit(Servicio $servicio)
    {
        return view('servicios::admin.servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Servicio $servicio
     * @param  Request $request
     * @return Response
     */
    public function update(Servicio $servicio, ServiciosRequest $request)
    {
        $this->servicio->update($servicio, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('servicios::servicios.title.servicios')]));

        return redirect()->route('admin.servicios.servicio.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Servicio $servicio
     * @return Response
     */
    public function destroy(Servicio $servicio)
    {
        $this->servicio->destroy($servicio);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('servicios::servicios.title.servicios')]));

        return redirect()->route('admin.servicios.servicio.index');
    }
}
