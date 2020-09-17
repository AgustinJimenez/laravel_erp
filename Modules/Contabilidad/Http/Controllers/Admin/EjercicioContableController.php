<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\TipoCuenta;
use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Contabilidad\Http\Requests\TipoCuentaRequest;
use Session;

class EjercicioContableController extends AdminBaseController
{

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
    public function index(Request $request)
    {
        $ejercicio_actual = Session::get('ejercicio_nombre');

        $año_actual=date("Y");

        $ejercicios_disponibles= array();

        for ($i=2016; $i <= $año_actual+1; $i++) 
        { 
            $ejercicios_disponibles[]="Ejercicio Contable ".$i;
        }
        //dd($ejercicios_disponibles);

        return view('contabilidad::admin.ejercicio.index', compact('ejercicio_actual','ejercicios_disponibles'));
    }

    public function store(Request $request)
    {
        $ejercicio_check = $request->get('ejercicio_seleccionado');

        $año_actual=date("Y");

        $ejercicios_disponibles= array();

        for ($i=2016; $i <= $año_actual+1; $i++) 
        { 
            
            $ejercicios_disponibles[]="Ejercicio Contable ".$i;

            $ejercicio[]=$i;
        }

        $ejercicio_seleccionado_nombre = $ejercicios_disponibles[$ejercicio_check];

        $ejercicio_id = $ejercicio[$ejercicio_check];

        Session::put('ejercicio_nombre',$ejercicio_seleccionado_nombre);

        Session::put('ejercicio',$ejercicio_id);
        
        return redirect()->route('dashboard.index');
    }

}
