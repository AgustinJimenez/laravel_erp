<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\CuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Contabilidad\Http\Requests\CuentaRequest;
use Response;
use DB;

class CuentaController extends AdminBaseController
{
    /**
     * @var CuentaRepository
     */
    private $cuenta;

    public function __construct(CuentaRepository $cuenta)
    {
        parent::__construct();

        $this->cuenta = $cuenta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cuentas = $this->cuenta->all();

        return view('contabilidad::admin.cuentas.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $tipos = DB::table('contabilidad_tipo_cuenta')->lists('nombre','id')->all();

        dd($tipos);

        return view('contabilidad::admin.cuentas.create',compact('tipos'));
    }

    public function search_padre( Request $request )
    {
        $results = array();

        if ($request->has('term')  && trim($request->has('term') !== '') ) 
        {
            $queries = Cuenta::where('tiene_hijo',true)
                                ->where('nombre', 'like', "%{$request->get('term')}%")
                                ->take(7)
                                //->orderBy('nombre_apellido')
                                ->get(['id','nombre']);
            
        }
    
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->nombre];
        }

    return Response::json($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CuentaRequest $request)
    {
        $id_padre = $request->get('padre');

        $tiene_hijo = $request->get( 'tiene_hijo' );

        $tipo = $request->get( 'tipo' );
        
        if( $id_padre=='' )
        {
            $request['padre'] = null;
            $id_padre = null;
        }

        if( $tipo=='activo' )
            $codigo_tipo = '2';

        else if( $request->get('tipo')=='pasivo' )                                                            
            $codigo_tipo = '4';

        else if( $request->get('tipo')=='patrimonio_neto' )
            $codigo_tipo = '8';

        else if( $request->get('tipo')=='ingreso' )
            $codigo_tipo = '5';

        else if( $request->get('tipo')=='egreso' )
            $codigo_tipo = '3';

        /*
        $rest = substr("abcdef", 0, -1);  // devuelve "abcde"
        $rest = substr("abcdef", 0, -4);  // devuelve "ab" max=6
        $rest = substr("abcdef", 4, -4);  // devuelve false
        $rest = substr("abcdef", -3, -1); // devuelve "de"
        */

        $request['codigo'] = $codigo_tipo;

        $db_codigos = Cuenta::where('activo', true)->orderby('codigo','ASC')->get('codigo');

        if($id_padre == null && $tiene_hijo ==true)//is root
        {
            foreach ($db_codigos as $key => $db_codigo) 
            {
                $max=strlen( $db_codigo );

                if( substr($db_codigo,0,-($max-3) )!=($request['codigo'].'.'.($key+1)) )
                {

                };
            }
        }

        

        

        //$request=array_merge($request[],['codigo'=>'2']);

        

        dd( $request->all() );  

        $this->cuenta->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('contabilidad::cuentas.title.cuentas')]));

        return redirect()->route('admin.contabilidad.cuenta.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cuenta $cuenta
     * @return Response
     */
    public function edit(Cuenta $cuenta)
    {
        $cuenta = Cuenta::with('padre_nombre')->where('id', $cuenta->id)->first();

        dd($cuenta);

        return view('contabilidad::admin.cuentas.edit', compact('cuenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Cuenta $cuenta
     * @param  Request $request
     * @return Response
     */
    public function update(Cuenta $cuenta, Request $request)
    {
        $this->cuenta->update($cuenta, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('contabilidad::cuentas.title.cuentas')]));

        return redirect()->route('admin.contabilidad.cuenta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cuenta $cuenta
     * @return Response
     */
    public function destroy(Cuenta $cuenta)
    {
        $this->cuenta->destroy($cuenta);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('contabilidad::cuentas.title.cuentas')]));

        return redirect()->route('admin.contabilidad.cuenta.index');
    }
}
