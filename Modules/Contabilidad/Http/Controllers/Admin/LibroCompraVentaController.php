<?php namespace Modules\Contabilidad\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Ventas\Entities\Venta;
use Modules\Compras\Entities\Compra;
use Modules\Contabilidad\Entities\Cuenta;
use Modules\Contabilidad\Repositories\TipoCuentaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Contabilidad\Http\Requests\TipoCuentaRequest;
use Yajra\Datatables\Facades\Datatables;
use Session;
use Dompdf\Dompdf;
include( base_path().'/Modules/funciones_varias.php');
use Maatwebsite\Excel\Facades\Excel;

class LibroCompraVentaController extends AdminBaseController
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

    public function libro_venta_performance()
    {
        $venta = true;
        return view('contabilidad::admin.reportes.libro_compra_venta_performance', compact('venta'));
    }
     public function libro_compra_performance()
    {
        $compra = true;
        return view('contabilidad::admin.reportes.libro_compra_venta_performance', compact('compra'));
    }


    public function libro_venta_pdf(Request $request)
    {
        $fecha_inicio = date_to_server($request['fecha_inicio']);
        $fecha_fin = date_to_server($request['fecha_fin']);

        $año_ejercicio = Session::get('ejercicio');

        $libro_ventas = Venta::where('estado','terminado')
                            ->where('ventas__ventas.fecha_venta', '>=',$fecha_inicio)
                            ->where('ventas__ventas.fecha_venta','<=',$fecha_fin )
                            ->orderBy('fecha_venta')
                            ->get();
        //dd($libro_ventas[0]->factura->nro_factura);

        $fecha = date('d/m/Y');


            //$bootstrap_path = public_path().'/themes/adminlte/vendor/bootstrap/dist/css/bootstrap.css';
            $view= \View::make('contabilidad::admin.reportes.libro_compra_venta_pdf', compact('libro_ventas','año_ejercicio','fecha'));
            //return $view;
            $dompdf = new Dompdf();
            $dompdf->set_option("isPhpEnabled", true);
            $dompdf->loadHtml($view);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('libro_compra_venta_pdf', array("Attachment" => 0));//0 preview/ 1 download


        return view('libro_compra_venta_pdf', compact('libro_ventas','año_ejercicio','fecha'));
    }

    public function libro_venta_excel(Request $re)
    {
        $re['fecha_inicio_excel'] = date_to_server($re['fecha_inicio_excel']);

        $re['fecha_fin_excel'] = date_to_server($re['fecha_fin_excel']);

        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');

        $libro_ventas = Venta::where('estado','terminado')
                            ->where('ventas__ventas.fecha_venta', '>=',$re['fecha_inicio_excel'])
                            ->where('ventas__ventas.fecha_venta','<=',$re['fecha_fin_excel'] )
                            ->orderBy('fecha_venta')
                            ->get();

        foreach ($libro_ventas as $key => $registro)
        {
            $grabado_excenta = ($registro->grabado_excenta>0)?$registro->grabado_excenta:0;

            $grabado_5 = ($registro->grabado_5>0)?$registro->grabado_5:0;

            $grabado_10 = ($registro->grabado_10>0)?$registro->grabado_10:0;

            $total_iva_5 = ($registro->total_iva_5>0)?$registro->total_iva_5:0;

            $total_iva_10 = ($registro->total_iva_10>0)?$registro->total_iva_10:0;

            $total_grabado = ($registro->total_grabado > 0)?$registro->total_grabado:0;

            $registros[] = 
            [
                'Fecha' => $registro->format('fecha_venta','date'),
                'N° Factura' => $registro->factura->nro_factura, 
                'RUC' => $registro->cliente->ruc, 
                'Cliente' => $registro->cliente->razon_social ,
                'Subtotal Exento' => $grabado_excenta, 
                'Subtotal Gravado 5%' => $grabado_5, 
                'Subtotal Gravado 10%' => $grabado_10,
                'IVA 5%' => $total_iva_5,
                'IVA 10%' => $total_iva_10,
                'Total' => $total_grabado,
                'Fecha de Doc: ' . $fecha => '',
                'Ejercicio Contable: ' . $año_ejercicio => ''
            ];
        }

        //dd($registros);
        
        $libro_ventas = $registros;

        $excel_object = Excel::create('Libro_Venta_' . $fecha, function($excel) use ($libro_ventas) 
        {
            $excel->sheet('Libro_Venta_', function($sheet) use ($libro_ventas) 
            {
                $sheet->fromArray( $libro_ventas );
 
            });
        });

        $excel_object->export('xls');
    }


    public function libro_compra_pdf(Request $request)
    {
       
        $fecha_inicio = date_to_server( $request['fecha_inicio'] );

        $fecha_fin = date_to_server( $request['fecha_fin'] );

        $año_ejercicio = Session::get('ejercicio');

        $libro_compras = Compra::where('compras__compras.fecha', '>=', $fecha_inicio)
                            ->where('compras__compras.fecha','<=', $fecha_fin )
                            ->orderBy('fecha')
                            ->get();

        $fecha = date('d/m/Y');

        //$bootstrap_path = public_path().'/themes/adminlte/vendor/bootstrap/dist/css/bootstrap.css';
        $view= \View::make('contabilidad::admin.reportes.libro_compra_venta_pdf', compact('libro_compras','año_ejercicio','fecha'));
        //return $view;
        $dompdf = new Dompdf();
        $dompdf->set_option("isPhpEnabled", true);
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('libro_compra_venta_pdf', array("Attachment" => 0));
     
        return view('libro_compra_venta_pdf', compact('libro_compras','año_ejercicio','fecha'));
     }

     public function libro_compra_excel(Request $re)
    {
        $re['fecha_inicio_excel'] = date_to_server($re['fecha_inicio_excel']);

        $re['fecha_fin_excel'] = date_to_server($re['fecha_fin_excel']);

        $año_ejercicio = Session::get('ejercicio');

        $fecha = date('d/m/Y');

        $libro_compras = Compra::where('compras__compras.fecha', '>=', $re['fecha_inicio_excel'])
                            ->where('compras__compras.fecha','<=', $re['fecha_fin_excel'] )
                            ->orderBy('fecha')
                            ->get();

        //dd($libro_compras);

        foreach ($libro_compras as $key => $registro)
        {
            $grabado_excenta = ($registro->grabado_excenta>0)?$registro->grabado_excenta:0;

            $grabado_5 = ($registro->grabado_5>0)?$registro->grabado_5:0;

            $grabado_10 = ($registro->grabado_10>0)?$registro->grabado_10:0;

            $total_iva_5 = ($registro->total_iva_5>0)?$registro->total_iva_5:0;

            $total_iva_10 = ($registro->total_iva_10>0)?$registro->total_iva_10:0;

            $total_grabado_iva = ($registro->total_grabado_iva > 0)?$registro->total_grabado_iva:0;

            $registros[] = 
            [
                'Fecha' => $registro->format('fecha','date'),
                'N° Factura' => $registro->nro_factura, 
                'RUC' => $registro->ruc_proveedor, 
                'Cliente' => $registro->razon_social ,
                'Subtotal Exento' => $grabado_excenta, 
                'Subtotal Gravado 5%' => $grabado_5, 
                'Subtotal Gravado 10%' => $grabado_10,
                'IVA 5%' => $total_iva_5,
                'IVA 10%' => $total_iva_10,
                'Total' => $total_grabado_iva,
                'Fecha de Doc: ' . $fecha => '',
                'Ejercicio Contable: ' . $año_ejercicio => ''
            ];
        }

        //dd($registros);
        
        $libro_compras = $registros;

        $excel_object = Excel::create('Libro_Compra_' . $fecha, function($excel) use ($libro_compras) 
        {
            $excel->sheet('Libro_Compra_', function($sheet) use ($libro_compras) 
            {
                $sheet->fromArray( $libro_compras );
 
            });
        });

        $excel_object->export('xls');
            
     }


}
