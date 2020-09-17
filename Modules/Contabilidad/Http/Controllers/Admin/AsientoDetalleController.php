<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\AsientoDetalle;
use Modules\Contabilidad\Repositories\AsientoDetalleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AsientoDetalleController extends AdminBaseController
{
    /**
     * @var AsientoDetalleRepository
     */
    private $asientodetalle;

    public function __construct(AsientoDetalleRepository $asientodetalle)
    {
        parent::__construct();

        $this->asientodetalle = $asientodetalle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$asientodetalles = $this->asientodetalle->all();

        return view('contabilidad::admin.asientodetalles.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('contabilidad::admin.asientodetalles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->asientodetalle->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('contabilidad::asientodetalles.title.asientodetalles')]));

        return redirect()->route('admin.contabilidad.asientodetalle.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AsientoDetalle $asientodetalle
     * @return Response
     */
    public function edit(AsientoDetalle $asientodetalle)
    {
        return view('contabilidad::admin.asientodetalles.edit', compact('asientodetalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AsientoDetalle $asientodetalle
     * @param  Request $request
     * @return Response
     */
    public function update(AsientoDetalle $asientodetalle, Request $request)
    {
        $this->asientodetalle->update($asientodetalle, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('contabilidad::asientodetalles.title.asientodetalles')]));

        return redirect()->route('admin.contabilidad.asientodetalle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AsientoDetalle $asientodetalle
     * @return Response
     */
    public function destroy(AsientoDetalle $asientodetalle)
    {
        $this->asientodetalle->destroy($asientodetalle);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::asientodetalles.title.asientodetalles')]));

        return redirect()->route('admin.contabilidad.asientodetalle.index');
    }
}
