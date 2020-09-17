<?php namespace Modules\Ventas\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UpdatePreventaController extends AdminBaseController
{
	public function preventa_agregar_items(\Venta $preventa, Request $re)
    {
        \DB::beginTransaction();
        try
        {
        	$re['detalle'] = $this->blank_to_null( $re['detalle'] );
        	$detalle = new \DetalleVenta;
        	$detalle->fill($re['detalle']);
        	$detalle->venta_id = $preventa->id;

            if( $detalle->producto_id )
            {
                $producto = \Producto::find($detalle->producto_id);
                $producto->stock -= $detalle->cantidad;
                $detalle->costo_unitario = $producto->precio_compra_promedio;
                $producto->save();
            }
            else if( $detalle->cristal_id )
                $detalle->costo_unitario = \TipoCristales::find( $detalle->cristal_id )->first()->precio_costo;

            $preventa->monto_total += $detalle->precio_total;
            $numero_a_letra = new \NumberToLetterConverter;
            $preventa->monto_total_letras = $numero_a_letra->to_word( $preventa->monto_total, "guaranies");
            if( $detalle->iva == '11')
            {
                $total_item_con_iva_10 = $detalle->precio_unitario * $detalle->cantidad;
                $total_iva_10 = $total_item_con_iva_10/11;

                $preventa->total_iva_10 += $total_iva_10;
                $preventa->grabado_10 += $total_item_con_iva_10 - $total_iva_10;
                $preventa->grabado_10 = (int)$preventa->grabado_10;
                $preventa->total_iva_10 = (int)$preventa->total_iva_10;
            }
            else if($detalle->iva == '21')
            {
                $total_item_con_iva_5 = $detalle->precio_unitario * $detalle->cantidad;
                $total_iva_5 = $total_item_con_iva_5/21;

                $preventa->total_iva_5 += $total_iva_5;
                $preventa->grabado_5 += (int)$total_item_con_iva_5 - $total_iva_5;
                $preventa->grabado_5 = (int)$preventa->grabado_5;
                $preventa->total_iva_5 = (int)$preventa->total_iva_5;
            }
            else
                $preventa->grabado_excenta = (int)$detalle->precio_unitario * $detalle->cantidad;
            
            $preventa->total_iva = $preventa->total_iva_5 + $preventa->total_iva_10;

            
            $detalle->save();
            $preventa->save();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            flash()->error("Ocurrio un error al tratar de actualizar. " . $e->getMessage());
            return redirect()->back();
        }
        \DB::commit();
        flash()->success("Preventa Actualizada Correctamente.");
        return redirect()->back();
    }

    function blank_to_null( $array )
    {
    	if( !array_key_exists("cristal_id", $array) )
    		$array['cristal_id'] = null;

    	foreach($array as $key => $value)
    	{
    		if( $key == "cantidad" )
    			$value = (double)str_replace(",", ".", $value);
    		if( $key == "precio_unitario" or $key == "precio_total" or $key == "iva")
    			$value = (int)str_replace(".", "", $value);

    		if( $key != "descripcion")
    			$array[$key] = ($value == "")?null:$value;
    	}

    	return $array;
    }
}