<?php namespace Modules\Proveedores\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Proveedores\Entities\Proveedor;
use Modules\Proveedores\Http\Requests\ProveedoresRequest;
use Modules\Proveedores\Repositories\ProveedorRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Yajra\Datatables\Facades\Datatables;
use Response;

class ProveedorController extends AdminBaseController
{
    /**
     * @var ProveedorRepository
     */
    private $proveedor;

    public function __construct(ProveedorRepository $proveedor)
    {
        parent::__construct();

        $this->proveedor = $proveedor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $proveedors = $this->proveedor->all();

        return view('proveedores::admin.proveedors.index', compact('proveedors'));
    }

    public function indexAjax(Request $request)
    {
        $query = Proveedor::select(['razon_social', 'ruc', 'direccion','telefono','contacto','id']);
        
        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.proveedores.proveedor.edit";

                $asDestroy = "admin.proveedores.proveedor.destroy";

                $editRoute = route($asEdit, [$tabla->id]);

                $deleteRoute = route($asDestroy, [$tabla->id]);

                $buttons="<div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
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
            ->filter(function ($query) use ($request)
            {
                if ($request->has('razon_social')  && trim($request->has('razon_social') !== '') )
                {

                    $query->where('razon_social', 'like', "%{$request->get('razon_social')}%");

                }

                if ($request->has('ruc')  && trim($request->has('ruc') !== '') )
                {

                    $query->where('ruc', 'like', "%{$request->get('ruc')}%");

                }

            })
            ->make(true);

            //dd( $object );

        return $object;
    }

    public function search_proveedor( Request $request )
    {
        $results = array();

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Proveedor::where('razon_social', 'like', "%{$request->get('term')}%")
                            ->take(7)
                            //->orderBy('nombre_apellido')
                            ->get(['id','razon_social','ruc']);
            
        }
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->razon_social, 'ruc' => $query->ruc];
        }

    return Response::json($results);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('proveedores::admin.proveedors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(ProveedoresRequest $request)
    {
        try 
        {
            $proveedor = Proveedor::create($request->all());

            flash()->success(trans('core::core.messages.resource created', ['name' => trans('proveedores::proveedors.title.proveedors')]));

            $success = true;
        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Ocurrio un error, no se pudo crear al proveedor.');

            $success = false;
        }
        finally
        {
            if( $request['isCompra'] )
            {
                return response()->json(['success' => $success, 'id' => $proveedor->id, 'razon_social' => $proveedor->razon_social, 'ruc' => $proveedor->ruc]);
            }
            else
            {
                return redirect()->route('admin.proveedores.proveedor.index');
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Proveedor $proveedor
     * @return Response
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores::admin.proveedors.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Proveedor $proveedor
     * @param  Request $request
     * @return Response
     */
    public function update(Proveedor $proveedor, ProveedoresRequest $request)
    {
        $this->proveedor->update($proveedor, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('proveedores::proveedors.title.proveedors')]));

        return redirect()->route('admin.proveedores.proveedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Proveedor $proveedor
     * @return Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $this->proveedor->destroy($proveedor);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('proveedores::proveedors.title.proveedors')]));

        return redirect()->route('admin.proveedores.proveedor.index');
    }
}
