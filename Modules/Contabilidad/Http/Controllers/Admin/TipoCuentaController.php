<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\TipoCuenta;
use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Contabilidad\Http\Requests\TipoCuentaRequest;

class TipoCuentaController extends AdminBaseController
{
    /**
     * @var TipoCuentaRepository
     */
    private $tipocuenta;

    public function __construct(TipoCuentaRepository $tipocuenta)
    {
        parent::__construct();

        $this->tipocuenta = $tipocuenta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tipocuentas = TipoCuenta::orderBy('codigo')->get()->all();

        return view('contabilidad::admin.tipocuentas.index', compact('tipocuentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('contabilidad::admin.tipocuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(TipoCuentaRequest $request)
    {
        $this->tipocuenta->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('contabilidad::tipocuentas.title.tipocuentas')]));

        return redirect()->route('admin.contabilidad.tipocuenta.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TipoCuenta $tipocuenta
     * @return Response
     */
    public function edit(TipoCuenta $tipocuenta)
    {
        return view('contabilidad::admin.tipocuentas.edit', compact('tipocuenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TipoCuenta $tipocuenta
     * @param  Request $request
     * @return Response
     */
    public function update(TipoCuenta $tipocuenta, TipoCuentaRequest $request)
    {
        $this->tipocuenta->update($tipocuenta, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('contabilidad::tipocuentas.title.tipocuentas')]));

        return redirect()->route('admin.contabilidad.tipocuenta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TipoCuenta $tipocuenta
     * @return Response
     */
    public function destroy(TipoCuenta $tipocuenta)
    {
        $this->tipocuenta->destroy($tipocuenta);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::tipocuentas.title.tipocuentas')]));

        return redirect()->route('admin.contabilidad.tipocuenta.index');
    }
}
