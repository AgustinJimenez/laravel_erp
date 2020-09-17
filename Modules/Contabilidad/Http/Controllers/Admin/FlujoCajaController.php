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

class FlujoCajaController extends AdminBaseController
{

    public function flujo_caja_config()
    {
        //dd("hola");
        $año_actual=date("Y");
        
        for ($i=2016; $i <= $año_actual+1; $i++) 
        { 
           $año_ingreso_egreso[] =$i;
        }
        
        foreach ($año_ingreso_egreso as $key => $años_disponibles) 
        {
            $años[$años_disponibles] = $años_disponibles;
        }

        return view('contabilidad::admin.reportes.flujo_caja_config', compact('años'));
    }

    
    public function flujo_caja(Request $request)
    {
        $anho = (int)$request['year'];

        $meses= ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $total_entradas =0; 
        $total_salidas =0; 
        $total_general =0; 
        $compras = array();
        $salarios = array();
        $egresos = array();
       
        // Calculo para Compras
        for ($i=1; $i<= 12 ; $i++) 
        { 
            $aux = DB::table('compras_pagos')
                        ->whereYear('fecha','=',$anho)
                        ->whereMonth('fecha','=',$i)
                        ->select((DB::raw("(MONTH(fecha)) as mes")),
                                 (DB::raw('(SUM(monto)) as suma_mes')))
                        ->lists('suma_mes','mes');

            $compras[]= $aux;
            
        }
        //dd($compras);
        // Calculo para salario
        for ($i=1; $i<= 12 ; $i++) 
        { 
            $aux = DB::table('empleados__pagoempleados')
                    ->whereYear('fecha','=',$anho)
                    ->whereMonth('fecha','=',$i)
                    ->select((DB::raw("(MONTH(fecha)) as mes")),
                             (DB::raw('(SUM(salario)) as suma_mes')))
                    ->lists('suma_mes','mes');

            $salarios[]= $aux;
        }
        //dd($salarios);
        // Calculo para Ventas
        for ($i=1; $i<= 12 ; $i++) 
        { 
            $aux = DB::table('ventas_pago_factura_credito')
                    ->whereYear('fecha','=',$anho)
                    ->whereMonth('fecha','=',$i)
                    ->select((DB::raw("(MONTH(fecha)) as mes")),
                             (DB::raw('(SUM(monto)) as suma_mes')))
                    ->lists('suma_mes','mes');

            $ventas[]= $aux;
        }
        //Total de Ventas
        for ($i=0 ; $i<= 11 ; $i++) 
        {
            foreach ($ventas[$i] as $key => $venta) 
            {
                $aux_venta = $venta;
            }

            $sum = (int)$venta;
            
            $entradas[] = $sum;  
                
        }
        

        //Total de Salarios + Compras
        for ($i=0 ; $i<= 11 ; $i++) 
        {
            foreach ($salarios[$i] as $key => $salario) 
            {
                $aux_salario = $salario;
            }

            foreach ($compras[$i] as $key => $compra) 
            {
                $aux_compra = $compra;
            }
            $sum = $aux_salario + $aux_compra;
            
            $salidas[] = (int)$sum;       
        }

        for ($i=0; $i <count($entradas) ; $i++) 
        { 
            $diferencia[]= $entradas[$i] - $salidas[$i]; 
        }


        for ($i=0; $i <11 ; $i++) 
        { 
           $total_entradas+= $entradas[$i]; 
           $total_salidas+= $salidas[$i];  
        }

        $total_general= $total_entradas - $total_salidas;
        

        return view('contabilidad::admin.reportes.flujo_caja', compact('anho','meses','salidas','entradas','diferencia','total_salidas','total_entradas','total_general'));
    }
        

    //     //Total de Salarios + Compras
    //     for ($i=0 ; $i<= 11 ; $i++) 
    //     {
    //         foreach ($salarios[$i] as $key => $salario) 
    //         {
    //             $aux_salario = $salario;
    //         }

    //         foreach ($compras[$i] as $key => $compra) 
    //         {
    //             $aux_compra = $compra;
    //         }
    //         $sum = $aux_salario + $aux_compra;
    //         //  dd($egreso);
    //         $egresos[] = (int)$sum;       
    //     }

    //     //dd($egresos);
    //     for ($i=0; $i <count($ingresos) ; $i++) 
    //     { 
    //         $diferencia[]=  $ingresos[$i] - $egresos[$i]; 
    //     }


    //     for ($i=0; $i <11 ; $i++) 
    //     { 
    //        $total_ingreso+=  $ingresos[$i]; 
    //        $total_egreso+=$egresos[$i];  
    //     }

    //     $total_general= $total_ingreso - $total_egreso;
        

    //     return view('contabilidad::admin.reportes.ingreso_egreso', compact('anho','meses','egresos','ingresos','diferencia','total_egreso','total_ingreso','total_general'));
    // }


      

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
