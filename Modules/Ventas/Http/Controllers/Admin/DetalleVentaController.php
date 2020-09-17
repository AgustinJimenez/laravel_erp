<?php namespace Modules\Ventas\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Ventas\Entities\DetalleVenta;
use Modules\Ventas\Repositories\DetalleVentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DetalleVentaController extends AdminBaseController
{
    /**
     * @var DetalleVentaRepository
     */
    private $detalleventa;

    public function __construct(DetalleVentaRepository $detalleventa)
    {
        parent::__construct();

        $this->detalleventa = $detalleventa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$detalleventas = $this->detalleventa->all();

        return view('ventas::admin.detalleventas.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ventas::admin.detalleventas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->detalleventa->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('ventas::detalleventas.title.detalleventas')]));

        return redirect()->route('admin.ventas.detalleventa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  DetalleVenta $detalleventa
     * @return Response
     */
    public function edit(DetalleVenta $detalleventa)
    {   
        // dd($detalleventa);
        return view('ventas::admin.detalleventas.edit', compact('detalleventa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DetalleVenta $detalleventa
     * @param  Request $request
     * @return Response
     */
    public function update(DetalleVenta $detalleventa, Request $request)
    {
        $this->detalleventa->update($detalleventa, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('ventas::detalleventas.title.detalleventas')]));

        return redirect()->route('admin.ventas.detalleventa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DetalleVenta $detalleventa
     * @return Response
     */
    public function destroy(DetalleVenta $detalleventa)
    {
        $this->detalleventa->destroy($detalleventa);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('ventas::detalleventas.title.detalleventas')]));

        return redirect()->route('admin.ventas.detalleventa.index');
    }
}
