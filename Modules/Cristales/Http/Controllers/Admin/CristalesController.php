<?php namespace Modules\Cristales\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Cristales\Entities\Cristales;
use Modules\Cristales\Repositories\CristalesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Cristales\Http\Requests\CristalRequest;
use Modules\Cristales\Entities\CategoriaCristales;


class CristalesController extends AdminBaseController
{
    /**
     * @var CristalesRepository
     */
    private $cristales;

    public function __construct(CristalesRepository $cristales)
    {
        parent::__construct();

        $this->cristales = $cristales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cristales = $this->cristales->all();

        return view('cristales::admin.cristales.index', compact('cristales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categorias = CategoriaCristales::lists('nombre','id')->all();

        //dd($categorias);

        return view('cristales::admin.cristales.create', compact('categorias') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CristalRequest $request)
    {
        //dd( $request->all() );

        $this->cristales->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('cristales::cristales.title.cristales')]));

        return redirect()->route('admin.cristales.cristales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cristales $cristales
     * @return Response
     */
    public function edit(Cristales $cristales)
    {
        $categorias = CategoriaCristales::lists('nombre','id')->all();

        return view('cristales::admin.cristales.edit', compact('cristales','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Cristales $cristales
     * @param  Request $request
     * @return Response
     */
    public function update(Cristales $cristales, CristalRequest $request)
    {
        $this->cristales->update($cristales, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('cristales::cristales.title.cristales')]));

        return redirect()->route('admin.cristales.cristales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cristales $cristales
     * @return Response
     */
    public function destroy(Cristales $cristales)
    {
        if( count($cristales->tipocristales)>0 )
        {
            flash()->error('Ya hay tipos o graduaciones creadas con este cristal');

            return redirect()->back();
        }

        $this->cristales->destroy($cristales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('cristales::cristales.title.cristales')]));

        return redirect()->route('admin.cristales.cristales.index');
    }
}
