<?php namespace Modules\Empleados\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Empleados\Http\Requests\EmpleadoRequest;
use Modules\Empleados\Entities\Empleado;
use Modules\Empleados\Repositories\EmpleadoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
class EmpleadoController extends AdminBaseController
{
    /**
     * @var EmpleadoRepository
     */
    private $empleado;

    public function __construct(EmpleadoRepository $empleado)
    {
        parent::__construct();

        $this->empleado = $empleado;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('empleados::admin.empleados.index');
    }

    public function indexAjax(Request $request)
    {
        $query = Empleado::select(['id', 'nombre', 'apellido', 'cedula', 'cargo','ruc','activo']);

        $object = Datatables::of( $query )
            ->addColumn('action', function ($tabla) 
            {
                $asEdit = "admin.empleados.empleado.edit";

                $asDestroy = "admin.empleados.empleado.destroy";

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $buttons="<div class='btn-group'>
                            <a href='". $editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                            <!--
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='". $deleteRoute ."'>
                                <i class='fa fa-trash'></i>
                            </button>
                            -->
                        </div>";

                return $buttons;
            })
            ->filter(function ($query) use ($request)
            {
                if ($request->has('nombre')  && trim($request->has('nombre') !== '') )
                {

                    $query->where('nombre', 'like', "%{$request->get('nombre')}%");

                }

                if ($request->has('apellido')  && trim($request->has('apellido') !== '') )
                {

                    $query->where('apellido', 'like', "%{$request->get('apellido')}%");

                }

                if ($request->has('cedula')  && trim($request->has('cedula') !== '') )
                {

                    $query->where('cedula', 'like', "%{$request->get('cedula')}%");

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
        return view('empleados::admin.empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(EmpleadoRequest $request)
    {
        $this->empleado->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('empleados::empleados.title.empleados')]));

        return redirect()->route('admin.empleados.empleado.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Empleado $empleado
     * @return Response
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados::admin.empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Empleado $empleado
     * @param  Request $request
     * @return Response
     */
    public function update(Empleado $empleado, EmpleadoRequest $request)
    {
        $this->empleado->update($empleado, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('empleados::empleados.title.empleados')]));

        return redirect()->route('admin.empleados.empleado.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Empleado $empleado
     * @return Response
     */
    public function destroy(Empleado $empleado)
    {
        $this->empleado->destroy($empleado);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('empleados::empleados.title.empleados')]));

        return redirect()->route('admin.empleados.empleado.index');
    }
}
