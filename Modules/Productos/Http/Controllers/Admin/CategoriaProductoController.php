<?php namespace Modules\Productos\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Productos\Entities\CategoriaProducto;
use Modules\Productos\Repositories\CategoriaProductoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Productos\Http\Requests\CategoriaProductoRequest;

class CategoriaProductoController extends AdminBaseController
{
    /**
     * @var CategoriaProductoRepository
     */
    private $categoriaproducto;

    public function __construct(CategoriaProductoRepository $categoriaproducto)
    {
        parent::__construct();

        $this->categoriaproducto = $categoriaproducto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categoriaproductos = $this->categoriaproducto->all();

        return view('productos::admin.categoriaproductos.index', compact('categoriaproductos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('productos::admin.categoriaproductos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CategoriaProductoRequest $request)
    {
        foreach ($request->all() as $key => $value) 
            if(!$value)
                if($key == 'codigo')
                    $request[$key] = null;

        $this->categoriaproducto->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('productos::categoriaproductos.title.categoriaproductos')]));

        return redirect()->route('admin.productos.categoriaproducto.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CategoriaProducto $categoriaproducto
     * @return Response
     */
    public function edit(CategoriaProducto $categoriaproducto)
    {
        return view('productos::admin.categoriaproductos.edit', compact('categoriaproducto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoriaProducto $categoriaproducto
     * @param  Request $request
     * @return Response
     */
    public function update(CategoriaProducto $categoriaproducto, CategoriaProductoRequest $request)
    {
        $this->categoriaproducto->update($categoriaproducto, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('productos::categoriaproductos.title.categoriaproductos')]));

        return redirect()->route('admin.productos.categoriaproducto.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CategoriaProducto $categoriaproducto
     * @return Response
     */
    public function destroy(CategoriaProducto $categoriaproducto)
    {
        if( count($categoriaproducto->producto)>0 )
        {
            flash()->error('La categoria ya tiene productos');

            return redirect()->back();
        }
        
        $this->categoriaproducto->destroy($categoriaproducto);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('productos::categoriaproductos.title.categoriaproductos')]));

        return redirect()->route('admin.productos.categoriaproducto.index');
    }
}
