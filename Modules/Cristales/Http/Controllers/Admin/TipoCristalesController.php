<?php namespace Modules\Cristales\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Cristales\Entities\TipoCristales;
use Modules\Cristales\Repositories\TipoCristalesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Cristales\Entities\CategoriaCristales;
use Modules\Cristales\Entities\Cristales;

use Modules\Cristales\Http\Requests\TipoCristalRequest;
use Response;

class TipoCristalesController extends AdminBaseController
{
    /**
     * @var TipoCristalesRepository
     */
    private $tipocristales;

    public function __construct(TipoCristalesRepository $tipocristales)
    {
        parent::__construct();

        $this->tipocristales = $tipocristales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tipocristales = $this->tipocristales->all();

        return view('cristales::admin.tipocristales.index', compact('tipocristales'));
    }

    public function search_cristal( Request $request )
    {
        $id = $request->get('id');

        $results = array();

        if ( $id ) 
        {
            $query = TipoCristales::where('activo',true)
                            ->where('id',$id)
                            ->first();

            $result = $query->precio_venta;

            return Response::json($result);
        }
        else
        {
            return Response::json(0);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $re)
    {
        $permisos = collect($re->user()->get_full_permisos->get("Permisos Especiales Cristales"));
        $categorias = CategoriaCristales::get();
        $cristales = Cristales::get();
        return view('cristales::admin.tipocristales.create', compact('categorias', 'cristales', 'permisos') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(TipoCristalRequest $request)
    {
        //dd( $request->except('_token') );

        $this->tipocristales->create($request->all());

        flash()->success(" Tipo o Graduacion creado correctamente.");

        return redirect()->route('admin.cristales.tipocristales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TipoCristales $tipocristales
     * @return Response
     */
    public function edit(TipoCristales $tipocristales, Request $re)
    {
        $permisos = collect($re->user()->get_full_permisos->get("Permisos Especiales Cristales"));
        $categorias = CategoriaCristales::get();

        $cristales = Cristales::get();

        return view('cristales::admin.tipocristales.edit', compact('tipocristales','categorias', 'cristales', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TipoCristales $tipocristales
     * @param  Request $request
     * @return Response
     */
    public function update(TipoCristales $tipocristales, TipoCristalRequest $request)
    {
        $this->tipocristales->update($tipocristales, $request->all());

        flash()->success(" Tipo o Graduacion actualizado correctamente");

        return redirect()->route('admin.cristales.tipocristales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TipoCristales $tipocristales
     * @return Response
     */
    public function destroy(TipoCristales $tipocristales)
    {
        if( count($tipocristales->detalles_ventas)>0 )
        {
            flash()->error('Ya hay ventas con este tipo o graduacion');

            return redirect()->back();
        }

        $this->tipocristales->destroy($tipocristales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('cristales::tipocristales.title.tipocristales')]));

        return redirect()->route('admin.cristales.tipocristales.index');
    }
}
