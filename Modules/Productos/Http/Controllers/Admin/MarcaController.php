<?php namespace Modules\Productos\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Productos\Http\Requests\MarcaRequest;
use Modules\Productos\Entities\Marca;
use Modules\Productos\Repositories\MarcaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MarcaController extends AdminBaseController
{
    /**
     * @var MarcaRepository
     */
    private $marca;

    public function __construct(MarcaRepository $marca)
    {
        parent::__construct();

        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $marcas = $this->marca->all();

        return view('productos::admin.marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('productos::admin.marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(MarcaRequest $request)
    {
        if(!$request->get('codigo'))$request['codigo'] = null;
        $this->marca->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('productos::marcas.title.marcas')]));

        return redirect()->route('admin.productos.marca.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Marca $marca
     * @return Response
     */
    public function edit(Marca $marca)
    {
        return view('productos::admin.marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Marca $marca
     * @param  Request $request
     * @return Response
     */
    public function update(Marca $marca, MarcaRequest $request)
    {
        $this->marca->update($marca, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('productos::marcas.title.marcas')]));

        return redirect()->route('admin.productos.marca.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Marca $marca
     * @return Response
     */
    public function destroy(Marca $marca)
    {
        if( count($marca->producto)>0 )
        {
            flash()->error('La marca ya tiene productos');

            return redirect()->back();
        }

        $this->marca->destroy($marca);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('productos::marcas.title.marcas')]));

        return redirect()->route('admin.productos.marca.index');
    }
}
