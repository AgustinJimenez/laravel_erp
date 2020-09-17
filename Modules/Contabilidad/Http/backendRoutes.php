<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/contabilidad'], function (Router $router) {
    $router->bind('tipocuenta', function ($id) {
        return app('Modules\Contabilidad\Repositories\TipoCuentaRepository')->find($id);
    });
    $router->get('tipocuentas', [
        'as' => 'admin.contabilidad.tipocuenta.index',
        'uses' => 'TipoCuentaController@index',
        'middleware' => 'can:contabilidad.tipocuentas.index'
    ]);

    $router->get('tipocuentas/create', [
        'as' => 'admin.contabilidad.tipocuenta.create',
        'uses' => 'TipoCuentaController@create',
        'middleware' => 'can:contabilidad.tipocuentas.create'
    ]);

    $router->post('tipocuentas', [
        'as' => 'admin.contabilidad.tipocuenta.store',
        'uses' => 'TipoCuentaController@store',
        'middleware' => 'can:contabilidad.tipocuentas.store'
    ]);
    $router->get('tipocuentas/{tipocuenta}/edit', [
        'as' => 'admin.contabilidad.tipocuenta.edit',
        'uses' => 'TipoCuentaController@edit',
        'middleware' => 'can:contabilidad.tipocuentas.edit'
    ]);
    $router->put('tipocuentas/{tipocuenta}', [
        'as' => 'admin.contabilidad.tipocuenta.update',
        'uses' => 'TipoCuentaController@update',
        'middleware' => 'can:contabilidad.tipocuentas.update'
    ]);
    $router->delete('tipocuentas/{tipocuenta}', [
        'as' => 'admin.contabilidad.tipocuenta.destroy',
        'uses' => 'TipoCuentaController@destroy',
        'middleware' => 'can:contabilidad.tipocuentas.destroy'
    ]);
    $router->bind('cuenta', function ($id) {
        return app('Modules\Contabilidad\Repositories\CuentaRepository')->find($id);
    });
    $router->get('cuentas', [
        'as' => 'admin.contabilidad.cuenta.index',
        'uses' => 'CuentaController@index',
        'middleware' => 'can:contabilidad.cuentas.index'
    ]);

    $router->post('cuentas/index_ajax_filter', [
        'as' => 'admin.contabilidad.cuenta.index_ajax_filter',
        'uses' => 'CuentaController@index_ajax_filter',
        'middleware' => 'can:contabilidad.cuentas.index_ajax_filter'
    ]);

    $router->get('cuentas/create', [
        'as' => 'admin.contabilidad.cuenta.create',
        'uses' => 'CuentaController@create',
        'middleware' => 'can:contabilidad.cuentas.create'
    ]);
    $router->post('cuentas', [
        'as' => 'admin.contabilidad.cuenta.store',
        'uses' => 'CuentaController@store',
        'middleware' => 'can:contabilidad.cuentas.store'
    ]);
    $router->get('cuentas/search_padre', [
        'as' => 'admin.contabilidad.cuenta.search_padre',
        'uses' => 'CuentaController@search_padre',
        'middleware' => 'can:contabilidad.cuentas.search_padre'
    ]);
    $router->get('cuentas/search_cuenta_asiento', [
        'as' => 'admin.contabilidad.cuenta.search_cuenta_asiento',
        'uses' => 'CuentaController@search_cuenta_asiento',
        'middleware' => 'can:contabilidad.cuentas.search_cuenta_asiento'
    ]);
    $router->get('cuentas/{cuenta}/edit', [
        'as' => 'admin.contabilidad.cuenta.edit',
        'uses' => 'CuentaController@edit',
        'middleware' => 'can:contabilidad.cuentas.edit'
    ]);
    $router->put('cuentas/{cuenta}', [
        'as' => 'admin.contabilidad.cuenta.update',
        'uses' => 'CuentaController@update',
        'middleware' => 'can:contabilidad.cuentas.update'
    ]);
    $router->delete('cuentas/{cuenta}', [
        'as' => 'admin.contabilidad.cuenta.destroy',
        'uses' => 'CuentaController@destroy',
        'middleware' => 'can:contabilidad.cuentas.destroy'
    ]);
    $router->get('cuentas/{cuenta}/historial', [
        'as' => 'admin.contabilidad.cuenta.historial',
        'uses' => 'CuentaController@historial',
        'middleware' => 'can:contabilidad.cuentas.historial'
    ]);
    $router->post('cuentas/historial_ajax', [
        'as' => 'admin.contabilidad.cuenta.historial_ajax',
        'uses' => 'CuentaController@historial_ajax',
        'middleware' => 'can:contabilidad.cuentas.historial_ajax'
    ]);
    $router->post('cuentas/historial_excel', [
        'as' => 'admin.contabilidad.cuenta.historial_excel',
        'uses' => 'CuentaController@historial_excel',
        'middleware' => 'can:contabilidad.cuentas.historial_excel'
    ]);
    $router->get('cuentas/cuenta_exist', [
        'as' => 'admin.contabilidad.cuenta.cuenta_exist',
        'uses' => 'CuentaController@cuenta_exist',
        'middleware' => 'can:contabilidad.cuentas.cuenta_exist'
    ]);
    
//////////////////////ASIENTO/////////////////////////////////////
    $router->bind('asiento', function ($id) {
        return app('Modules\Contabilidad\Repositories\AsientoRepository')->find($id);
    });
    $router->get('asientos', [
        'as' => 'admin.contabilidad.asiento.index',
        'uses' => 'AsientoController@index',
        'middleware' => 'can:contabilidad.asientos.index'
    ]);

    $router->get('asientos/index_ajax_asientos', [
        'as' => 'admin.contabilidad.asiento.index_ajax_asientos',
        'uses' => 'AsientoController@index_ajax_asientos',
        'middleware' => 'can:contabilidad.asientos.index_ajax_asientos'
    ]);

    $router->get('asientos/create', [
        'as' => 'admin.contabilidad.asiento.create',
        'uses' => 'AsientoController@create',
        'middleware' => 'can:contabilidad.asientos.create'
    ]);
    $router->post('asientos', [
        'as' => 'admin.contabilidad.asiento.store',
        'uses' => 'AsientoController@store',
        'middleware' => 'can:contabilidad.asientos.store'
    ]);
    $router->get('asientos/{asiento}/edit', [
        'as' => 'admin.contabilidad.asiento.edit',
        'uses' => 'AsientoController@edit',
        'middleware' => 'can:contabilidad.asientos.edit'
    ]);
    $router->put('asientos/{asiento}', [
        'as' => 'admin.contabilidad.asiento.update',
        'uses' => 'AsientoController@update',
        'middleware' => 'can:contabilidad.asientos.update'
    ]);
    $router->delete('asientos/{asiento}', [
        'as' => 'admin.contabilidad.asiento.destroy',
        'uses' => 'AsientoController@destroy',
        'middleware' => 'can:contabilidad.asientos.destroy'
    ]);
    $router->get('asientos/{asiento}/anular', [
        'as' => 'admin.contabilidad.asiento.anular',
        'uses' => 'AsientoController@anular',
        'middleware' => 'can:contabilidad.asientos.anular'
    ]);
//////////////////////Libro Mayor/////////////////////////////////////

    $router->get('reportes/libro_mayor', [
        'as' => 'admin.contabilidad.reportes.libro_mayor',
        'uses' => 'LibroMayorController@libro_mayor',
        'middleware' => 'can:contabilidad.reportes.libro_mayor'
    ]);

    $router->get('reportes/cajas', [
        'as' => 'admin.contabilidad.reportes.cajas',
        'uses' => 'LibroMayorController@libro_mayor',
        'middleware' => 'can:contabilidad.reportes.libro_mayor'
    ]);

    $router->get('reportes/libro_mayor_index', [
        'as' => 'admin.contabilidad.reportes.libro_mayor_index',
        'uses' => 'LibroMayorController@libro_mayor_index',
        'middleware' => 'can:contabilidad.reportes.libro_mayor_index'
    ]);

    $router->post('reportes/libro_mayor_pdf', [
        'as' => 'admin.contabilidad.reportes.libro_mayor_pdf',
        'uses' => 'LibroMayorController@libro_mayor_pdf',
        'middleware' => 'can:contabilidad.reportes.libro_mayor_pdf'
    ]);

    $router->post('reportes/libro_mayor_xls', [
        'as' => 'admin.contabilidad.reportes.libro_mayor_xls',
        'uses' => 'LibroMayorController@libro_mayor_xls',
        'middleware' => 'can:contabilidad.reportes.libro_mayor_xls'
    ]);

/////////////////////////Balance///////////////////////////////////


    $router->get('reportes/balance', [
        'as' => 'admin.contabilidad.reportes.balance',
        'uses' => 'BalanceController@balance',
        'middleware' => 'can:contabilidad.reportes.balance'
    ]);

    $router->get('reportes/balance_activos', [
        'as' => 'admin.contabilidad.reportes.balance_activos',
        'uses' => 'BalanceController@balance_activos',
        'middleware' => 'can:contabilidad.reportes.balance_activos'
    ]);

    $router->get('reportes/balance_pasivos', [
        'as' => 'admin.contabilidad.reportes.balance_pasivos',
        'uses' => 'BalanceController@balance_pasivos',
        'middleware' => 'can:contabilidad.reportes.balance_pasivos'
    ]);

    $router->get('reportes/balance_patrimonio', [
        'as' => 'admin.contabilidad.reportes.balance_patrimonio',
        'uses' => 'BalanceController@balance_patrimonio',
        'middleware' => 'can:contabilidad.reportes.balance_patrimonio'
    ]);

    $router->get('reportes/balance_pdf', [
        'as' => 'admin.contabilidad.reportes.balance_pdf',
        'uses' => 'BalanceController@balance_pdf',
        'middleware' => 'can:contabilidad.reportes.balance_pdf'
    ]);

///////////////////////////Resultado Total///////////////////////////////

    $router->get('reportes/estado_resultado', [
        'as' => 'admin.contabilidad.reportes.estado_resultado',
        'uses' => 'EstadoResultadoController@estado_resultado',
        'middleware' => 'can:contabilidad.reportes.estado_resultado'
    ]);

    $router->get('reportes/estado_resultado_ingresos', [
        'as' => 'admin.contabilidad.reportes.estado_resultado_ingresos',
        'uses' => 'EstadoResultadoController@estado_resultado_ingresos',
        'middleware' => 'can:contabilidad.reportes.estado_resultado_ingresos'
    ]);

    $router->get('reportes/estado_resultado_egresos', [
        'as' => 'admin.contabilidad.reportes.estado_resultado_egresos',
        'uses' => 'EstadoResultadoController@estado_resultado_egresos',
        'middleware' => 'can:contabilidad.reportes.estado_resultado_egresos'
    ]);

    $router->get('reportes/estado_resultado_pdf', [
        'as' => 'admin.contabilidad.reportes.estado_resultado_pdf',
        'uses' => 'EstadoResultadoController@estado_resultado_pdf',
        'middleware' => 'can:contabilidad.reportes.estado_resultado_pdf'
    ]);

    //////////////////////Libro Venta///////////////////////////////

    $router->get('reportes/libro_venta', [
        'as' => 'admin.contabilidad.reportes.libro_venta',
        'uses' => 'LibroCompraVentaController@libro_venta',
        'middleware' => 'can:contabilidad.reportes.libro_venta'
    ]);

    $router->post('reportes/libro_venta_pdf', [
        'as' => 'admin.contabilidad.reportes.libro_venta_pdf',
        'uses' => 'LibroCompraVentaController@libro_venta_pdf',
        'middleware' => 'can:contabilidad.reportes.libro_venta_pdf'
    ]);

    $router->post('reportes/libro_venta_excel', [
        'as' => 'admin.contabilidad.reportes.libro_venta_excel',
        'uses' => 'LibroCompraVentaController@libro_venta_excel',
        'middleware' => 'can:contabilidad.reportes.libro_venta_excel'
    ]);

    //////////////////////Libro Compra///////////////////////////////

    $router->get('reportes/libro_compra', [
        'as' => 'admin.contabilidad.reportes.libro_compra',
        'uses' => 'LibroCompraVentaController@libro_compra',
        'middleware' => 'can:contabilidad.reportes.libro_compra'
    ]);

    $router->post('reportes/libro_compra_pdf', [
        'as' => 'admin.contabilidad.reportes.libro_compra_pdf',
        'uses' => 'LibroCompraVentaController@libro_compra_pdf',
        'middleware' => 'can:contabilidad.reportes.libro_compra_pdf'
    ]);

    $router->post('reportes/libro_compra_excel', [
        'as' => 'admin.contabilidad.reportes.libro_compra_excel',
        'uses' => 'LibroCompraVentaController@libro_compra_excel',
        'middleware' => 'can:contabilidad.reportes.libro_compra_excel'
    ]);

    $router->get('reportes/libro_compra_performance', [
        'as' => 'admin.contabilidad.reportes.libro_compra_performance',
        'uses' => 'LibroCompraVentaController@libro_compra_performance',
        'middleware' => 'can:contabilidad.reportes.libro_compra_performance'
    ]);

    $router->get('reportes/libro_venta_performance', [
        'as' => 'admin.contabilidad.reportes.libro_venta_performance',
        'uses' => 'LibroCompraVentaController@libro_venta_performance',
        'middleware' => 'can:contabilidad.reportes.libro_venta_performance'
    ]);


/*----------------------------Ejercicio-------------------------------*/

    $router->get('ejercicio', [
        'as' => 'admin.contabilidad.ejercicio.index',
        'uses' => 'EjercicioContableController@index',
        'middleware' => 'can:contabilidad.ejercicio.index'
    ]);
    $router->get('ejercicio/create', [
        'as' => 'admin.contabilidad.ejercicio.create',
        'uses' => 'EjercicioContableController@create',
        'middleware' => 'can:contabilidad.ejercicio.create'
    ]);
    $router->post('ejercicio', [
        'as' => 'admin.contabilidad.ejercicio.store',
        'uses' => 'EjercicioContableController@store',
        'middleware' => 'can:contabilidad.ejercicio.store'
    ]);
    $router->get('ejercicio/{ejercicio}/edit', [
        'as' => 'admin.contabilidad.ejercicio.edit',
        'uses' => 'EjercicioContableController@edit',
        'middleware' => 'can:contabilidad.ejercicio.edit'
    ]);
    $router->put('ejercicio/{ejercicio}', [
        'as' => 'admin.contabilidad.ejercicio.update',
        'uses' => 'EjercicioContableController@update',
        'middleware' => 'can:contabilidad.ejercicio.update'
    ]);
    $router->delete('ejercicio/{ejercicio}', [
        'as' => 'admin.contabilidad.ejercicio.destroy',
        'uses' => 'EjercicioContableController@destroy',
        'middleware' => 'can:contabilidad.ejercicio.destroy'
    ]);

/*-------------------------------------------------------------------*/

/*----------------------------Ingresos y Egresos-------------------------------*/
    
    $router->post('reportes/ingreso_egreso', [
        'as' => 'admin.contabilidad.reportes.ingreso_egreso',
        'uses' => 'IngresoEgresoController@ingreso_egreso',
        'middleware' => 'can:contabilidad.reportes.ingreso_egreso'
    ]);

    $router->get('reportes/ingreso_egreso_config', [
        'as' => 'admin.contabilidad.reportes.ingreso_egreso_config',
        'uses' => 'IngresoEgresoController@ingreso_egreso_config',
        'middleware' => 'can:contabilidad.reportes.ingreso_egreso_config'
    ]);

    $router->post('reportes/ingreso_egreso_xls', [
        'as' => 'admin.contabilidad.reportes.ingreso_egreso_xls',
        'uses' => 'IngresoEgresoController@ingreso_egreso_xls',
        'middleware' => 'can:contabilidad.reportes.ingreso_egreso_xls'
    ]);

/*------------------------------------------------------------------------------*/

/*----------------------------Flujo Efectivo-------------------------------*/
    $router->get('reportes/flujo_efectivo', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo',
        'uses' => 'FlujoEfectivoController@flujo_efectivo',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo'
    ]);

    $router->post('reportes/flujo_efectivo/flujo_efectivo_ajax', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo_ajax',
        'uses' => 'FlujoEfectivoController@flujo_efectivo_ajax',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo_ajax'
    ]);

    $router->post('reportes/flujo_efectivo/flujo_efectivo_excel', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo_excel',
        'uses' => 'FlujoEfectivoController@flujo_efectivo_excel',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo_excel'
    ]);

    
/*----------------------------Flujo Efectivo-------------------------------*/

/*----------------------------Flujo Efectivo Detalles-------------------------------*/
    $router->get('reportes/flujo_efectivo_detalles', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo_detalles',
        'uses' => 'FlujoEfectivoDetallesController@flujo_efectivo_detalles',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo_detalles'
    ]);

    $router->post('reportes/flujo_efectivo/flujo_efectivo_detalles_ajax', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo_detalles_ajax',
        'uses' => 'FlujoEfectivoDetallesController@flujo_efectivo_detalles_ajax',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo_detalles_ajax'
    ]);

    $router->post('reportes/flujo_efectivo_detalles_excel', [
        'as' => 'admin.contabilidad.reportes.flujo_efectivo_detalles_excel',
        'uses' => 'FlujoEfectivoDetallesController@flujo_efectivo_detalles_excel',
        'middleware' => 'can:contabilidad.reportes.flujo_efectivo_detalles_excel'
    ]);
/*----------------------------Flujo Efectivo Detalles-------------------------------*/
    
/*----------------------------Flujo Caja-------------------------------*/
    
    $router->post('reportes/flujo_caja', [
        'as' => 'admin.contabilidad.reportes.flujo_caja',
        'uses' => 'FlujoCajaController@flujo_caja',
        'middleware' => 'can:contabilidad.reportes.flujo_caja'
    ]);

    $router->get('reportes/flujo_caja_config', [
        'as' => 'admin.contabilidad.reportes.flujo_caja_config',
        'uses' => 'FlujoCajaController@flujo_caja_config',
        'middleware' => 'can:contabilidad.reportes.flujo_caja_config'
    ]);

    $router->post('reportes/flujo_caja_xls', [
        'as' => 'admin.contabilidad.reportes.flujo_caja_xls',
        'uses' => 'FlujoCajaController@flujo_caja_xls',
        'middleware' => 'can:contabilidad.reportes.flujo_caja_xls'
    ]);


/*------------------------------------------------------------------------------*/

    $router->bind('asientodetalle', function ($id) {
        return app('Modules\Contabilidad\Repositories\AsientoDetalleRepository')->find($id);
    });
    $router->get('asientodetalles', [
        'as' => 'admin.contabilidad.asientodetalle.index',
        'uses' => 'AsientoDetalleController@index',
        'middleware' => 'can:contabilidad.asientodetalles.index'
    ]);
    $router->get('asientodetalles/create', [
        'as' => 'admin.contabilidad.asientodetalle.create',
        'uses' => 'AsientoDetalleController@create',
        'middleware' => 'can:contabilidad.asientodetalles.create'
    ]);
    $router->post('asientodetalles', [
        'as' => 'admin.contabilidad.asientodetalle.store',
        'uses' => 'AsientoDetalleController@store',
        'middleware' => 'can:contabilidad.asientodetalles.store'
    ]);
    $router->get('asientodetalles/{asientodetalle}/edit', [
        'as' => 'admin.contabilidad.asientodetalle.edit',
        'uses' => 'AsientoDetalleController@edit',
        'middleware' => 'can:contabilidad.asientodetalles.edit'
    ]);
    $router->put('asientodetalles/{asientodetalle}', [
        'as' => 'admin.contabilidad.asientodetalle.update',
        'uses' => 'AsientoDetalleController@update',
        'middleware' => 'can:contabilidad.asientodetalles.update'
    ]);
    $router->delete('asientodetalles/{asientodetalle}', [
        'as' => 'admin.contabilidad.asientodetalle.destroy',
        'uses' => 'AsientoDetalleController@destroy',
        'middleware' => 'can:contabilidad.asientodetalles.destroy'
    ]);
// append




});
