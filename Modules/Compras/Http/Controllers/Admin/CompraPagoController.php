<?php namespace Modules\Compras\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Compras\Entities\CompraPago;
use Modules\Contabilidad\Entities\Asiento;
use Modules\Contabilidad\Entities\AsientoDetalle;
use DB;
class CompraPagoController extends AdminBaseController 
{
	
	public function destroypago(CompraPago $pago)
	{
		$compra = $pago->compra;

        DB::beginTransaction();

        try
        {
            foreach ($pago->asientos as $key => $asiento) 
            {
                foreach ($asiento->detalles as $key => $detalle) 
                    $detalle->delete();

                $asiento->delete();
            }

            $pago->delete();

            $compra->total_pagado = $compra->total_pagado_pagos;

            $compra->save();

        }
        catch (ValidationException $e)
        {
            DB::rollBack();

            flash()->error('Ocurrio un error al intentar eliminar el pago.');

            return redirect()->back();
        }

        DB::commit();

        flash()->success('Pago Eliminado Correctamente.');

        return redirect()->back();
	}
	
}