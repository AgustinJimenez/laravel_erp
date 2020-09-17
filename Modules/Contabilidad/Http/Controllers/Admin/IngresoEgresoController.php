<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Contabilidad\Entities\TipoCuenta;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Contabilidad\Http\Requests\TipoCuentaRequest;
use Yajra\Datatables\Facades\Datatables;
use Session, DateTime;
use Dompdf\Dompdf;
use DB;

class IngresoEgresoController extends AdminBaseController
{
    public function ingreso_egreso_config()
    {
        $año_actual = date("Y");
        for ($i=2016; $i <= $año_actual+1; $i++) 
           $año_ingreso_egreso[] = $i;
        foreach ($año_ingreso_egreso as $key => $años_disponibles) 
            $años[$años_disponibles] = $años_disponibles;
        return view('contabilidad::admin.reportes.ingreso_egreso_config', compact('años', 'año_actual'));
    }

    
    public function ingreso_egreso(Request $request)
    {
        $anho = (int)$request['year'];

        $meses= ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $total_ingreso =0; 
        $total_egreso =0; 
        $total_general =0; 
        $compras = array();
        $salarios = array();
        $egresos = array();
       
        // Calculo para Compras
        for ($mes=1; $mes <= 12 ; $mes++) 
            $compras[] = DB::table('compras__compras')
                        ->whereYear('fecha','=',$anho)
                        ->whereMonth('fecha','=',$mes)
                        ->select
                        (
                            (DB::raw("(MONTH(fecha)) as mes")),
                            (DB::raw('(SUM(total_pagado)) as suma_mes'))
                        )
                        ->lists('suma_mes','mes');

        // Calculo para salario
        for ($mes =1; $mes <= 12 ; $mes++) 
            $salarios[] = DB::table('empleados__pagoempleados')
                    ->whereYear('fecha','=',$anho)
                    ->whereMonth('fecha','=',$mes)
                    ->select
                    (
                        (DB::raw("(MONTH(fecha)) as mes")),
                        (DB::raw('(SUM(salario)) as suma_mes'))
                    )
                    ->lists('suma_mes','mes');
        

        // Calculo para Ventas
        for ($mes =1; $mes <= 12 ; $mes++) 
            $ventas[] = DB::table('ventas__ventas')
                    ->whereYear('fecha_venta','=',$anho)
                    ->whereMonth('fecha_venta','=',$mes)
                    ->select
                    (
                        (DB::raw("(MONTH(fecha_venta)) as mes")),
                        (DB::raw('(SUM(total_pagado)) as suma_mes'))
                    )
                    ->lists('suma_mes','mes');

        //Total de Ventas
        for ($i=0 ; $i <= 11 ; $i++) 
        {
            foreach ($ventas[$i] as $key => $venta) 
                $aux_venta = $venta;
            

            $sum = (int)$venta;
            
            $ingresos[] = $sum;  
                
        }
        

        //Total de Salarios + Compras
        for ($i=0 ; $i<= 11 ; $i++) 
        {
            foreach ($salarios[$i] as $key => $salario) 
                $aux_salario = $salario;
            
            foreach ($compras[$i] as $key => $compra) 
                $aux_compra = $compra;

            $sum = $aux_salario + $aux_compra;
            //  dd($egreso);
            $egresos[] = (int)$sum;       
        }

        //dd($egresos);
        for ($i=0; $i <count($ingresos) ; $i++) 
            $diferencia[]=  $ingresos[$i] - $egresos[$i]; 


        for ($i=0; $i <11 ; $i++) 
        { 
           $total_ingreso+=  $ingresos[$i]; 
           $total_egreso+=$egresos[$i];  
        }

        $total_general= $total_ingreso - $total_egreso;

        if( $request->has('print_excel') )
        {
            //return view( 'contabilidad::admin.reportes.ingreso-egreso-excel', compact('anho','meses','egresos','ingresos','diferencia','total_egreso','total_ingreso','total_general') );

           \Excel::create('Reporte_Ingreso_Egreso_' . date("Y_m_d"), function($excel) use ($anho,$meses,$egresos,$ingresos,$diferencia,$total_egreso,$total_ingreso, $total_general)
            {
                $excel->sheet('Reporte_Ingreso_Egreso', function($sheet) use ($anho,$meses,$egresos,$ingresos,$diferencia,$total_egreso,$total_ingreso, $total_general)
                {
                    $sheet->loadView( 'contabilidad::admin.reportes.ingreso-egreso-excel', compact('anho','meses','egresos','ingresos','diferencia','total_egreso','total_ingreso','total_general') );
                });
            })->export('xls');
        }
        else
            return view('contabilidad::admin.reportes.ingreso_egreso', compact('anho','meses','egresos','ingresos','diferencia','total_egreso','total_ingreso','total_general'));
    }



      

    public function ingreso_egreso_xls()
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
        //dd($libro_mayor);
        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');
    
            $view= \View::make('contabilidad::admin.reportes.pdf', compact('query','año_ejercicio','fecha'));
            //return $view;
            $dompdf = new Dompdf();
            $dompdf->set_option("isPhpEnabled", true);
            $dompdf->loadHtml($view);
            //$dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('pdf', array("Attachment" => 0));
     
        return view('pdf', compact('query','año_ejercicio','fecha'));

     }


}
