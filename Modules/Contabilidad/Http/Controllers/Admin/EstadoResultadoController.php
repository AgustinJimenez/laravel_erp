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

class EstadoResultadoController extends AdminBaseController
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
    
    public function estado_resultado()
    {
        $profundidad = 1;

        $total_debe_ingreso=0;
        $total_haber_ingreso=0;
        $total_debe_egreso=0;
        $total_haber_egreso=0;

        $cuentas =Cuenta::where('profundidad',$profundidad)
                        ->lists('id');

        for ($i=0; $i < count($cuentas) ; $i++) 
        {    
            $cuentas_query = Cuenta::where('id', $cuentas[$i])->first();

            if ($cuentas_query->tipo == 4) 
            {
                $total_debe_ingreso+=$cuentas_query->totalEjercicioContable()->debe;
                $total_haber_ingreso+=$cuentas_query->totalEjercicioContable()->haber;
            } 
            elseif ($cuentas_query->tipo == 5) 
            {
                $total_debe_egreso+=$cuentas_query->totalEjercicioContable()->debe;
                $total_haber_egreso+=$cuentas_query->totalEjercicioContable()->haber;
            }
        }

        $resultado_ingreso = number_format(($total_haber_ingreso - $total_debe_ingreso), 0, '', '.');
        
        $resultado_egreso = number_format(($total_debe_egreso - $total_haber_egreso), 0, '', '.');

        return view('contabilidad::admin.reportes.estado_resultado', compact('resultado_ingreso','resultado_egreso'));
    }
      
      
    public function estado_resultado_ingresos(Request $request)
    {
        //Ver otro modo
        $profundidad = 3;

        $ingresos = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('tipo_cuentas.codigo', 4)
        ->where('contabilidad__cuentas.profundidad','<=',$profundidad)
        ->orderBy('contabilidad__cuentas.codigo')
            ->select
            ([
                'contabilidad__cuentas.id as id',
                'contabilidad__cuentas.codigo', //codigo
                'tipo_cuentas.nombre as tipo_nombre', //tipo
                'contabilidad__cuentas.nombre',//nombre
                'contabilidad__cuentas.tiene_hijo as tiene_hijo',
                'contabilidad__cuentas.activo as activo',
                'contabilidad__cuentas.profundidad as profundidad'
            ]);

        $object = Datatables::of( $ingresos )
            
            ->addColumn('totales', function ($tabla) 
            {   
                $total_ingreso = ($tabla->totalEjercicioContable()->haber)-($tabla->totalEjercicioContable()->debe);
                return number_format($total_ingreso, 0, '', '.');
            })
                        
            ->editColumn('codigo',' @if($profundidad==1)
                                            <?php echo "<b>$codigo</b>"; ?>                                            
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->make( true );

            
        return $object;

    }

    //PASIVO
     public function estado_resultado_egresos(Request $request)
    {
        //Ver otro modo
        $profundidad = 3;

        $egresos = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('tipo_cuentas.codigo', 5)
        ->where('contabilidad__cuentas.profundidad','<=',$profundidad)
        
            ->select
            ([
                'contabilidad__cuentas.id as id',
                'contabilidad__cuentas.codigo', //codigo
                'tipo_cuentas.nombre as tipo_nombre', //tipo
                'contabilidad__cuentas.nombre',//nombre
                'contabilidad__cuentas.tiene_hijo as tiene_hijo',
                'contabilidad__cuentas.activo as activo',
                'contabilidad__cuentas.profundidad as profundidad'
            ]);    

        $objeto = Datatables::of( $egresos )
            

            ->addColumn('totales', function ($tabla) 
            {   
                $total_egreso = ($tabla->totalEjercicioContable()->debe)-($tabla->totalEjercicioContable()->haber);
                return number_format($total_egreso, 0, '', '.');
            })
            
            ->editColumn('codigo',' @if($profundidad==1)
                                            <?php echo "<b>$codigo</b>"; ?>                                            
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->make( true );

            
        return $objeto;

    }

    public function estado_resultado_pdf()
    {
        $query = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
            ->select
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

        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');
        //$debe = totalEjercicioContable()->debe;

        //$haber = totalEjercicioContable()->haber;
        //dd($fecha);

        $view =  \View::make('contabilidad::admin.reportes.pdf', compact('query','deber', 'haber','año_ejercicio','fecha'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);  

        return $pdf->stream('contabilidad::admin.reportes.pdf'); 

     }

}
