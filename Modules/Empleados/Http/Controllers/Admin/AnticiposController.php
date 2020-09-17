<?php namespace Modules\Empleados\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use DB;
class AnticiposController extends AdminBaseController 
{
	
	public function index()
	{
		$anticipos = \Anticipo::select('id', 'empleado_id', 'fecha', 'monto', 'observacion', 'descontado', 'anulado')
						->orderBy('fecha', "DESC")
						->get();
		return view('empleados::admin.anticipos.index', compact('anticipos') );
	}

	public function create()
	{
		$anticipo = new \Anticipo();
		$anticipo->fill( ['fecha' => date("d/m/Y"), "monto" => 0] );
		$empleados = \Empleado::select('id', DB::raw('CONCAT(nombre," ",apellido) as nombre_ape'))
								->orderBy('nombre_ape')
								->lists('nombre_ape', 'id')
								->toArray();
		return view('empleados::admin.anticipos.create', compact('anticipo', 'empleados') );
	}
	public function store(Request $re)
	{
		$anticipo = new \Anticipo();
        $anticipo->fill( $re->anticipo )->save();
        $anticipo->generar_asientos( $re->user()->id );
        flash()->success('Anticipo creado correctamente');
        return redirect()->route('admin.empleados.anticipos.index');
	}
	public function edit(\Anticipo $anticipo)
	{
		//dd($anticipo->anulado);
		return view('empleados::admin.anticipos.edit', compact('anticipo') );
	}
	public function update(Request $re, \Anticipo $anticipo)
	{
		$anticipo->fill( $re->anticipo )->save();
		flash()->success('Anticipo actualizado correctamente');
        return redirect()->route('admin.empleados.anticipos.index');
	}
	public function anular(Request $re, \Anticipo $anticipo)
	{//ya se verifica en la vista
		$anticipo->anulado = true;
		$anticipo->save();
		$anticipo->asientos->first()->generar_contraasiento( $re->user()->id );
		flash()->success('Anticipo anulado correctamente');
        return redirect()->route('admin.empleados.anticipos.index');
	}




}