<?php namespace Modules\Cristales\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Cristales\Entities\CategoriaCristales;
use Modules\Cristales\Repositories\CategoriaCristalesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Cristales\Http\Requests\CategoriaCristalRequest;

class CategoriaCristalesController extends AdminBaseController
{
    /**
     * @var CategoriaCristalesRepository
     */
    private $categoriacristales;

    public function __construct(CategoriaCristalesRepository $categoriacristales)
    {
        parent::__construct();

        $this->categoriacristales = $categoriacristales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categoriacristales = $this->categoriacristales->all();

        return view('cristales::admin.categoriacristales.index', compact('categoriacristales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('cristales::admin.categoriacristales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CategoriaCristalRequest $request)
    {
        $this->categoriacristales->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('cristales::categoriacristales.title.categoriacristales')]));

        return redirect()->route('admin.cristales.categoriacristales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CategoriaCristales $categoriacristales
     * @return Response
     */
    public function edit(CategoriaCristales $categoriacristales)
    {
        return view('cristales::admin.categoriacristales.edit', compact('categoriacristales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoriaCristales $categoriacristales
     * @param  Request $request
     * @return Response
     */
    public function update(CategoriaCristales $categoriacristales, CategoriaCristalRequest $request)
    {
        $this->categoriacristales->update($categoriacristales, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('cristales::categoriacristales.title.categoriacristales')]));

        return redirect()->route('admin.cristales.categoriacristales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CategoriaCristales $categoriacristales
     * @return Response
     */
    public function destroy(CategoriaCristales $categoriacristales)
    {
        if( count($categoriacristales->tipocristales)>0 )
        {
            flash()->error('Ya hay tipos o graduaciones creadas con esta categoria');

            return redirect()->back();
        }

        $this->categoriacristales->destroy($categoriacristales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('cristales::categoriacristales.title.categoriacristales')]));

        return redirect()->route('admin.cristales.categoriacristales.index');
    }
}
