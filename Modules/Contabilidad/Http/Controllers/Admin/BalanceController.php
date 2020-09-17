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

class BalanceController extends AdminBaseController
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
    
    public function balance()
    {
       
        $tipos = TipoCuenta::orderBy('id')->get(['nombre','id']);

        return view('contabilidad::admin.reportes.balance', compact('tipos'));
    }
      
     //ACTIVO 
    public function balance_activos(Request $request)
    {
        //Ver otro modo
        $profundidad = 3;

        $query = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('tipo_cuentas.codigo', 1)
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

        $object = Datatables::of( $query )
            
            ->addColumn('totales', function ($tabla) 
            {   
                $total = ($tabla->totalEjercicioContable()->debe)-($tabla->totalEjercicioContable()->haber);
                return number_format($total, 0, '', '.');
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
     public function balance_pasivos(Request $request)
    {
        //Ver otro modo
        $profundidad = 3;

        $query_2 = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('tipo_cuentas.codigo', 2)
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

        $objeto = Datatables::of( $query_2 )
            

            ->addColumn('totales', function ($tabla) 
            {   
                $total = ($tabla->totalEjercicioContable()->haber)-($tabla->totalEjercicioContable()->debe);
                return number_format($total, 0, '', '.');
            })
            
            ->editColumn('codigo',' @if($profundidad==1)
                                            <?php echo "<b>$codigo</b>"; ?>                                            
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->make( true );

            
        return $objeto;

    }

    //PATRIMONIO NETO
     public function balance_patrimonio(Request $request)
    {
        $profundidad = 3;

        $query_3 = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('tipo_cuentas.codigo', 3)
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

        $objeto = Datatables::of( $query_3 )
            

           ->addColumn('totales', function ($tabla) 
            {   
                $total = ($tabla->totalEjercicioContable()->haber)-($tabla->totalEjercicioContable()->debe);
                return number_format($total, 0, '', '.');
            })
            
            ->editColumn('codigo',' @if($profundidad==1)
                                            <?php echo "<b>$codigo</b>"; ?>                                            
                                        @else
                                           <?php echo "$codigo"; ?>
                                        @endif')
            ->make( true );

            
        return $objeto;

    }

    public function balance_pdf()
    {
        $profundidad = 3;
        $balance = Cuenta::join('contabilidad__tipocuentas as tipo_cuentas','tipo_cuentas.id','=','contabilidad__cuentas.tipo')
        ->leftjoin('contabilidad__cuentas as cuenta_padre','cuenta_padre.id','=','contabilidad__cuentas.padre')
        ->where('contabilidad__cuentas.codigo','like', '03%')
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
                
            ])->get();

        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');

        $view= \View::make('contabilidad::admin.reportes.pdf', compact('balance','año_ejercicio','fecha'));
            //return $view;
            $dompdf = new Dompdf();
            $dompdf->set_option("isPhpEnabled", true);
            $dompdf->loadHtml($view);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('pdf', array("Attachment" => 0));
     
        return view('pdf', compact('balance','año_ejercicio','fecha'));

     }

}
