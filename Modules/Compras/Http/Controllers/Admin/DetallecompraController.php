<?php namespace Modules\Compras\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Compras\Entities\Detallecompra;
use Modules\Compras\Repositories\DetallecompraRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DetallecompraController extends AdminBaseController
{
    /**
     * @var DetallecompraRepository
     */
    private $detallecompra;

    public function __construct(DetallecompraRepository $detallecompra)
    {
        parent::__construct();

        $this->detallecompra = $detallecompra;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$detallecompras = $this->detallecompra->all();

        return view('compras::admin.detallecompras.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('compras::admin.detallecompras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->detallecompra->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('compras::detallecompras.title.detallecompras')]));

        return redirect()->route('admin.compras.detallecompra.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Detallecompra $detallecompra
     * @return Response
     */
    public function edit(Detallecompra $detallecompra)
    {
        return view('compras::admin.detallecompras.edit', compact('detallecompra'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Detallecompra $detallecompra
     * @param  Request $request
     * @return Response
     */
    public function update(Detallecompra $detallecompra, Request $request)
    {
        $this->detallecompra->update($detallecompra, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('compras::detallecompras.title.detallecompras')]));

        return redirect()->route('admin.compras.detallecompra.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Detallecompra $detallecompra
     * @return Response
     */
    public function destroy(Detallecompra $detallecompra)
    {
        $this->detallecompra->destroy($detallecompra);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('compras::detallecompras.title.detallecompras')]));

        return redirect()->route('admin.compras.detallecompra.index');
    }
}
