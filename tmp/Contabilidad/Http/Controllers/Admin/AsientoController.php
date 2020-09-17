<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Repositories\AsientoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
        //$asientos = $this->asiento->all();

        return view('contabilidad::admin.asientos.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('contabilidad::admin.asientos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->asiento->create($request->all());

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
        return view('contabilidad::admin.asientos.edit', compact('asiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Asiento $asiento
     * @param  Request $request
     * @return Response
     */
    public function update(Asiento $asiento, Request $request)
    {
        $this->asiento->update($asiento, $request->all());

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
        $this->asiento->destroy($asiento);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::asientos.title.asientos')]));

        return redirect()->route('admin.contabilidad.asiento.index');
    }
}
