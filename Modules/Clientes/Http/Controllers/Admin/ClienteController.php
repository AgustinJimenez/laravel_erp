<?php namespace Modules\Clientes\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Clientes\Http\Requests\ClienteRequest;
use Modules\Clientes\Entities\Cliente;
use Modules\Clientes\Repositories\ClienteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Facades\Datatables;
use Response;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Media\Entities\File;
class ClienteController extends AdminBaseController
{
    /**
     * @var ClienteRepository
     */
    private $cliente;

    public function __construct(ClienteRepository $cliente)
    {
        parent::__construct();

        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $re)
    {
        $permisos = collect( $re->user()->get_full_permisos->get("Permisos Especiales Clientes") );
        
        return view('clientes::admin.clientes.index', compact('permisos') );
    }

    public function index_ajax(Request $request)
    {

        //dd($request->all());
        $query = Cliente::select(['id', 'razon_social', 'cedula', 'ruc', 'telefono','activo']);

        $clientes = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.clientes.cliente.edit";

                $asDestroy = "admin.clientes.cliente.destroy";

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $buttons = 
                        "<div class='btn-group'>
                            <a href='". $editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>";

                $buttons .= 
                        "<button class='btn btn-danger btn-flat button-eliminar' ventas='" . $tabla->ventas->count() . "' route='". $deleteRoute ."' >
                            <i class='fa fa-trash'></i>
                        </button>

                    </div>";

                return $buttons;
            })
            ->filter(function ($query) use ($request)
            {
                if ($request->has('razon_social')  && trim($request->has('razon_social') !== '') )
                {

                    $query->where('razon_social', 'like', "%{$request->get('razon_social')}%");

                }

                if ($request->has('cedula')  && trim($request->has('cedula') !== '') )
                {

                    $query->where('cedula', 'like', "%{$request->get('cedula')}%");

                }

                if ($request->has('ruc')  && trim($request->has('ruc') !== '') )
                {

                    $query->where('ruc', 'like', "%{$request->get('ruc')}%");

                }

                if ($request->has('estado')  && trim($request->has('estado') !== '') )
                {
                    
                    $query->where('activo',$request->get('estado') );
                }
            })
            ->editColumn('activo',' @if($activo)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->make(true);

        return $clientes;
    }

    public function upload_cliente_xls()
    {
        return view('clientes::admin.clientes.upload-cliente-xls');
    }

    public function descargar_ejemplo()
    {
        $file= base_path().'/public/assets/documentos/ejemplo_excel.xlsx';

        ///Documentacion/ejemplo_excel.xlsx

        $headers = array(
          'Content-Type: application/pdf',
        );
        
        return response()->download($file, 'ejemplo_excel.xlsx', $headers);;
    }

    public function upload_cliente_xls_store(Request $re)
    {
        $clientes = $this->get_xls_datas($re);

        //dd($clientes);

        DB::beginTransaction();

        try 
        {
            foreach ($clientes as $key => $cliente) 
                Cliente::create($cliente);
        }
        catch (\Exception $e) 
        {
            $message = $e->getMessage();

            $message = str_replace("Column 'razon_social' cannot be null", 'La razon social es requerida', $message);

            $message = str_replace("for key 'clientes__clientes_ruc_", ' ', $message);
            
            $message = str_replace("Duplicate entry", 'Algunos Datos ya existen en la base de datos', $message);

            $message = str_replace("SQLSTATE[23000]: Integrity constraint violation:", 'Error:', $message);

            $message = str_replace("(SQL: insert into `clientes__clientes` (`razon_social`, `cedula`, `ruc`, `direccion`, `email`, `telefono`, `celular`, `activo`, `updated_at`, `created_at`) ", '', $message);

            DB::Rollback();

            flash()->error($message);

            return redirect()->back();
        }

        DB::commit();

        flash()->success('Clientes Cargados Correctamente.');

        return redirect(route('admin.clientes.cliente.index'));
    }

    public function search_cliente( Request $request )
    {
        $results = array();

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Cliente::where('activo',true)
                            ->where('razon_social', 'like', "%{$request->get('term')}%")
                            ->take(7)
                            //->orderBy('nombre_apellido')
                            ->get(['id','razon_social']);
            
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
        return view('clientes::admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(ClienteRequest $request)
    {
        //dd( $request->all() );

        try 
        {
            $cliente = Cliente::create($request->all());



            flash()->success(trans('Cliente creado satisfactoriamente.', ['name' => trans('clientes::clientes.title.clientes')]));

            $success = true;
        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Ocurrio un error, no se pudo crear al cliente.');

            $success = false;
        }
        finally
        {
            if($request['isVentaCliente'] || $request['isPreVentaCliente'] )
            {
                if(isset($cliente))
                    return response()->json(['success' => $success, 'id' => $cliente->id, 'razon_social' => $cliente->razon_social]);
                else
                    return response()->json(['success' => $success, 'id' => '', 'razon_social' => '']);
            }
            else
            {

                return redirect()->route('admin.clientes.cliente.index');
            }

        }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cliente $cliente
     * @return Response
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes::admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Cliente $cliente
     * @param  Request $request
     * @return Response
     */
    public function update(Cliente $cliente, ClienteRequest $request)
    {
        $this->cliente->update($cliente, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('clientes::clientes.title.clientes')]));

        return redirect()->route('admin.clientes.cliente.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cliente $cliente
     * @return Response
     */
    public function destroy(Cliente $cliente)
    {
        if( $cliente->ventas->count() )
        {
            flash()->error("No se puede eliminar al cliente, tiene asociado alguna venta");
            return redirect()->back();
        }

        $this->cliente->destroy($cliente);

        flash()->success("Cliente eliminado correctamente");

        return redirect()->route('admin.clientes.cliente.index');
    }

    function get_xls_datas($re)
    {
        $archivo = File::where('id', $re['medias_single']['archivo'])->first();

        $file_path = base_path().'/public/assets/media/'.$archivo->filename;

        $columns = Excel::load($file_path)->get();
        
        if (strpos($archivo->filename, 'ods')) 
        {
            foreach ($columns as $key => $column) 
            foreach ($column as $key2 => $row) 
            {
                $cliente = $row->all();

                foreach ($cliente as $key3 => $campo) 
                    if( gettype($campo) == 'double' )
                        $cliente[$key3] = (string)intval($campo);
                if($cliente['activo'] )
                    $cliente['activo'] = '1';
                else
                    $cliente['activo'] = '0';

                $clientes[] = $cliente;

            }
        }
        else
        {
            foreach ($columns as $key => $row) 
            {
                $cliente = $row->all();

                foreach ($cliente as $key3 => $campo) 
                    if( gettype($campo) == 'double' )
                        $cliente[$key3] = (string)intval($campo);
                if($cliente['activo'] )
                    $cliente['activo'] = '1';
                else
                    $cliente['activo'] = '0';

                $clientes[] = $cliente;

            }
        }

        //dd($clientes);

        return $clientes;
    }
}
