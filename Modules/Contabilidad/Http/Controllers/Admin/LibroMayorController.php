<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\TipoCuenta;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Contabilidad\Http\Requests\TipoCuentaRequest;
use Yajra\Datatables\Facades\Datatables;
use Session;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
include( base_path().'/Modules/funciones_varias.php');

class LibroMayorController extends AdminBaseController
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
    
    public function libro_mayor(Request $re)
    {
        if($re['hay_cuenta'])
        {
            //dd( $re->all() );
            $cuenta = Cuenta::where('codigo', $re['codigo_cuenta_padre'])->first();

            $titulo = $re['titulo'];

            $hay_cuenta = $re['hay_cuenta'];

            return view('contabilidad::admin.reportes.libro_mayor', compact('cuenta', 'titulo', 'hay_cuenta'));
        }
        else
        {
            $cuentas = Cuenta::all();
            $tipos = TipoCuenta::orderBy('id')->get(['nombre','id']);

            return view('contabilidad::admin.reportes.libro_mayor', compact('cuentas','tipos'));
        }

        
    }
      
    public function libro_mayor_index(Request $request)
    {
        $request->fecha_desde = date_to_server($request->fecha_desde);

        $request->fecha_hasta = date_to_server($request->fecha_hasta);
        
        $query = $this->libro_mayor_query($request);

            $query->orderBy('codigo')
            ->select
            ([
                'contabilidad__cuentas.id as id',
                'contabilidad__cuentas.codigo', //codigo
                'tipo_cuentas.nombre as tipo_nombre', //tipo
                'contabilidad__cuentas.nombre',//nombre
                'contabilidad__cuentas.tiene_hijo as tiene_hijo',
                'contabilidad__cuentas.activo as activo'
            ]);

        $query_clone = $query->get();

        foreach ($query_clone as $key => $value) 
        {
            $ejercicio_contable = $value->totalEjercicioContable($request->fecha_desde ,$request->fecha_hasta);

            $value->debe = $ejercicio_contable->debe;

            $value->haber = $ejercicio_contable->haber;

            $value->saldo = $ejercicio_contable->saldo;

        }

        $object = Datatables::of( $query )
            ->addColumn('debe', function ($tabla) use ($query_clone)
            {   
                $debe = $query_clone->where('id', $tabla->id)->first()->debe;
                return number_format($debe, 0, '', '.');
            })

            ->addColumn('haber', function ($tabla) use ($query_clone)
            {   
                $haber = $query_clone->where('id', $tabla->id)->first()->haber;
                return number_format($haber, 0, '', '.');
            })

            ->addColumn('saldo', function ($tabla)  use ($query_clone)
            {   
                $saldo = $query_clone->where('id', $tabla->id)->first()->saldo;
                return number_format($saldo, 0, '', '.');
            })
            ->editColumn('codigo',' @if($tiene_hijo==1)
                                            <?php echo "<b>$codigo</b>"; ?>                                            
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->editColumn('tipo_nombre',' @if($tiene_hijo==1)
                                        <?php echo "<b>$tipo_nombre</b>"; ?>                                            
                                        @else
                                           <?php echo "$tipo_nombre"; ?>
                                        @endif')
            ->editColumn('nombre', function($tabla)
            {

                $base_path = 'admin.contabilidad.cuenta.';

                $as_historial = $base_path."historial";

                $historial_route = route( $as_historial, [$tabla->id]);

                $formulario = '<form action="'.$historial_route.'" method="get" target="_blank">
                                    <input type="hidden" name="fecha_inicio_historial">
                                    <input type="hidden" name="fecha_fin_historial">
                                </form>';

                if(!$tabla->tiene_hijo)
                    return "<a  class='to_historial'><b>".$tabla->nombre."</b></a>" . $formulario;
                else
                    return $tabla->nombre;
            })
            ->editColumn('debe',' @if($tiene_hijo==1)
                                        <?php echo "<b>$debe</b>"; ?>                                            
                                        @else
                                           <?php echo "$debe"; ?>
                                        @endif')
            ->editColumn('haber',' @if($tiene_hijo==1)
                                        <?php echo "<b>$haber</b>"; ?>                                            
                                        @else
                                           <?php echo "$haber"; ?>
                                        @endif')
            ->make( true );

            
        return $object;

    }

    public function libro_mayor_pdf(Request $re)
    {
        $fecha_inicio = date_to_server( $re['fecha_inicio_pdf'] );
        
        $fecha_fin = date_to_server( $re['fecha_fin_pdf'] );

        $query = $this->libro_mayor_query($re);

            $query->select
            ([
                'contabilidad__cuentas.id as id',
                'contabilidad__cuentas.codigo', //codigo
                'tipo_cuentas.nombre as tipo_nombre', //tipo
                'contabilidad__cuentas.nombre',//nombre
                'contabilidad__cuentas.tiene_hijo as tiene_hijo',
                'contabilidad__cuentas.activo as activo'
            ])
            ->orderBy('codigo')
            ->get();
        //dd($libro_mayor);
        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');
    
            $view= \View::make('contabilidad::admin.reportes.pdf', compact('query','año_ejercicio','fecha', 'fecha_inicio', 'fecha_fin'));
            //return $view;
            $dompdf = new Dompdf();
            $dompdf->set_option("isPhpEnabled", true);
            $dompdf->loadHtml($view);
            //$dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('pdf', array("Attachment" => 0));
     
        //return view('pdf', compact('query','año_ejercicio','fecha', 'fecha_inicio', 'fecha_fin'));

     }

    public function libro_mayor_xls(Request $re)
    {
        $re['fecha_inicio_xls'] = date_to_server( $re['fecha_inicio_xls'] );

        $re['fecha_fin_xls'] = date_to_server( $re['fecha_fin_xls'] );

        $cuentas = $this->libro_mayor_query($re);

        $cuentas->select
        ([
            'contabilidad__cuentas.id as id',
            'contabilidad__cuentas.codigo as codigo', //codigo
            'tipo_cuentas.nombre as tipo_nombre', //tipo
            'contabilidad__cuentas.nombre',//nombre
            'contabilidad__cuentas.tiene_hijo as tiene_hijo',
            'contabilidad__cuentas.activo as activo'
        ])
        ->orderBy('codigo');

        $cuentas = $cuentas->get();

        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');

        $collections = [];

        foreach ($cuentas as $key => $cuenta)
        {
            $ejercicio = $cuenta->totalEjercicioContable($re['fecha_inicio_xls'], $re['fecha_fin_xls']);

            $debe = $ejercicio->debe;

            $haber = $ejercicio->haber;

            $saldo = $ejercicio->saldo;

            $collections[] = 
            [
                'Código ' => $cuenta->codigo, 
                'Tipo' => $cuenta->tipo_nombre, 
                'Nombre' => $cuenta->nombre, 
                'Debe' =>   (int)$debe, 
                'Haber' => (int)$haber, 
                'Saldo' => (int)$saldo, 
                'Fecha de Doc: ' . $fecha => '', 
                'Ejercicio Contable: ' . $año_ejercicio => '', 
                'Fecha Inicio: '.date_from_server($re['fecha_inicio_xls']) => '', 
                'Fecha Fin: '.date_from_server($re['fecha_fin_xls']) => '' 
            ];
        
        }
        
        $cuentas = collect($collections);

        Excel::create('Reporte_Libro_Mayor_'.$fecha, function($excel) use ($cuentas) 
        {
            $excel->sheet('Libro Mayor', function($sheet) use ($cuentas) 
            {
                $sheet->fromArray($cuentas);
 
            });
        })->export('xls');

    }

    function libro_mayor_query($re)
    {
        //dd( $re->all() );

        if($re['cuenta_id_xls'])
            $re['cuenta_id'] = $re['cuenta_id_xls'];
        else if($re['cuenta_id_pdf'])
            $re['cuenta_id'] = $re['cuenta_id_pdf'];

        if($re['codigo_xls'])
            $re['codigo'] = $re['codigo_xls'];

        if($re['tipo_xls'])
            $re['tipo_nombre'] = $re['tipo_xls'];

        if($re['nombre_xls'])
            $re['nombre'] = $re['nombre_xls'];

        $query = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre');

        if( $re['cuenta_id'] )
            $query->where('contabilidad__cuentas.id', $re['cuenta_id'])->orWhere('contabilidad__cuentas.padre', $re['cuenta_id']);
        
        if ($re->has('codigo')  && trim($re->has('codigo') !== '') )
            $query->where('contabilidad__cuentas.codigo', 'like', "%{$re->get('codigo')}%");

        if ($re->has('tipo_nombre')  && trim($re->has('tipo_nombre') !== '') )
            $query->where('tipo_cuentas.nombre', '=', $re->get('tipo_nombre'));

        if ($re->has('nombre')  && trim($re->has('nombre') !== '') )
            $query->where('contabilidad__cuentas.nombre', 'like', "%{$re->get('nombre')}%");

        return $query;
    }


}
