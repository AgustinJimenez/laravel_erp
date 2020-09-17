<?php

use Illuminate\Routing\Router;
use Modules\Ventas\Entities\Venta;
/** @var Router $router */

$router->group(['prefix' =>'/ventas'], function (Router $router) 
{

    $router->bind('venta', function ($id) {
        return app('Modules\Ventas\Repositories\VentaRepository')->find($id);
    });

    $router->get('ventas', [
        'as' => 'admin.ventas.venta.index',
        'uses' => 'VentaController@index',
        'middleware' => 'can:ventas.ventas.index'
    ]);
    
    $router->get('ventas/preventas', [
        'as' => 'admin.ventas.venta.index_preventa',
        'uses' => 'VentaController@index_preventa',
        'middleware' => 'can:ventas.ventas.index_preventa'
    ]);

    $router->post('ventas/indexAjax', [
        'as' => 'admin.ventas.venta.indexAjax',
        'uses' => 'VentaController@indexAjax',
        'middleware' => 'can:ventas.ventas.indexAjax'
    ]);

    $router->post('ventas/nro_seguimiento_exist', [
        'as' => 'admin.ventas.venta.nro_seguimiento_exist',
        'uses' => 'VentaController@nro_seguimiento_exist',
        'middleware' => 'can:ventas.ventas.nro_seguimiento_exist'
    ]);

    $router->post('ventas/anular_factura/{venta}', [
        'as' => 'admin.ventas.venta.anular_factura',
        'uses' => 'VentaController@anular_factura',
        'middleware' => 'can:ventas.ventas.anular_factura'
    ]);

    $router->get('ventas/search_venta_cliente', [
        'as' => 'admin.ventas.venta.search_venta_cliente',
        'uses' => 'VentaController@search_venta_cliente',
        'middleware' => 'can:ventas.ventas.search_venta_cliente'
    ]);

    $router->get('ventas/search_venta_producto', [
        'as' => 'admin.ventas.venta.search_venta_producto',
        'uses' => 'VentaController@search_venta_producto',
        'middleware' => 'can:ventas.ventas.search_venta_producto'
    ]);

    $router->get('ventas/search_venta_servicio', [
        'as' => 'admin.ventas.venta.search_venta_servicio',
        'uses' => 'VentaController@search_venta_servicio',
        'middleware' => 'can:ventas.ventas.search_venta_servicio'
    ]);

    $router->get('ventas/search_venta_cristal', [
        'as' => 'admin.ventas.venta.search_venta_cristal',
        'uses' => 'VentaController@search_venta_cristal',
        'middleware' => 'can:ventas.ventas.search_venta_cristal'
    ]);

    $router->get('ventas/seleccion', [
        'as' => 'admin.ventas.venta.seleccion',
        'uses' => 'VentaController@seleccion',
        'middleware' => 'can:ventas.ventas.seleccion'
    ]);

    $router->get('ventas/detalle_venta_ajax', [
        'as' => 'admin.ventas.venta.detalle_venta_ajax',
        'uses' => 'VentaController@detalle_venta_ajax',
        'middleware' => 'can:ventas.ventas.detalle_venta_ajax'
    ]);

    $router->get('ventas/create', [
        'as' => 'admin.ventas.venta.create',
        'uses' => 'VentaController@create',
        'middleware' => 'can:ventas.ventas.create'
    ]);
    $router->post('ventas', [
        'as' => 'admin.ventas.venta.store',
        'uses' => 'VentaController@store',
        'middleware' => 'can:ventas.ventas.store'
    ]);
    $router->get('ventas/{venta}/edit', [
        'as' => 'admin.ventas.venta.edit',
        'uses' => 'VentaController@edit',
        'middleware' => 'can:ventas.ventas.edit'
    ]);
    $router->put('ventas/{venta}', [
        'as' => 'admin.ventas.venta.update',
        'uses' => 'VentaController@update',
        'middleware' => 'can:ventas.ventas.update'
    ]);
    $router->put('ventas/preventa_agregar_items/{venta}', [
        'as' => 'admin.ventas.venta.preventa_agregar_items',
        'uses' => 'UpdatePreventaController@preventa_agregar_items',
        'middleware' => 'can:ventas.ventas.preventa_agregar_items'
    ]);
    $router->delete('ventas/{venta}', [
        'as' => 'admin.ventas.venta.destroy',
        'uses' => 'VentaController@destroy',
        'middleware' => 'can:ventas.ventas.destroy'
    ]);
    $router->get('ventas/edit_nro_seguimiento', [
        'as' => 'admin.ventas.venta.edit_nro_seguimiento',
        'uses' => 'VentaController@edit_nro_seguimiento',
        'middleware' => 'can:ventas.ventas.edit_nro_seguimiento'
    ]);
    $router->post('ventas/update_nro_seguimiento', [
        'as' => 'admin.ventas.venta.update_nro_seguimiento',
        'uses' => 'VentaController@update_nro_seguimiento',
        'middleware' => 'can:ventas.ventas.update_nro_seguimiento'
    ]);
    /*REPORTE*/
    $router->get('ventas/reporte', [
        'as' => 'admin.ventas.venta.reporte',
        'uses' => 'VentaController@reporte',
        'middleware' => 'can:ventas.ventas.reporte'
    ]);

    $router->post('ventas/reporte_ajax', [
        'as' => 'admin.ventas.venta.reporte_ajax',
        'uses' => 'VentaController@reporte_ajax',
        'middleware' => 'can:ventas.ventas.reporte_ajax'
    ]);
    
    $router->post('ventas/query_reporte', [
        'as' => 'admin.ventas.venta.query_reporte',
        'uses' => 'VentaController@query_reporte',
        'middleware' => 'can:ventas.ventas.query_reporte'
    ]);

    $router->post('ventas/cuenta_change', [
        'as' => 'admin.ventas.venta.cuenta_change',
        'uses' => 'VentaController@cuenta_change',
        'middleware' => 'can:ventas.ventas.cuenta_change'
    ]);

    $router->get('ventas/reporte_xls', [
        'as' => 'admin.ventas.venta.reporte_xls',
        'uses' => 'VentaController@reporte_xls',
        'middleware' => 'can:ventas.ventas.reporte_xls'
    ]);
    /*REPORTE GANANCIAS*/
    $router->get('ventas/reporte_ganancias', [
        'as' => 'admin.ventas.venta.reporte_ganancias',
        'uses' => 'VentaController@reporte_ganancias',
        'middleware' => 'can:ventas.ventas.reporte_ganancias'
    ]);

    $router->post('ventas/reporte_ganancias_ajax', [
        'as' => 'admin.ventas.venta.reporte_ganancias_ajax',
        'uses' => 'VentaController@reporte_ganancias_ajax',
        'middleware' => 'can:ventas.ventas.reporte_ganancias_ajax'
    ]);

    $router->post('ventas/reporte_ganancias_query', [
        'as' => 'admin.ventas.venta.reporte_ganancias_query',
        'uses' => 'VentaController@reporte_ganancias_query',
        'middleware' => 'can:ventas.ventas.reporte_ganancias_query'
    ]);

    $router->get('ventas/reporte_ganancias_xls', [
        'as' => 'admin.ventas.venta.reporte_ganancias_xls',
        'uses' => 'VentaController@reporte_ganancias_xls',
        'middleware' => 'can:ventas.ventas.reporte_ganancias_xls'
    ]);
    $router->get('ventas/anular_asientos_preventa/{venta}', [
        'as' => 'admin.ventas.venta.anular_asientos_preventa',
        'uses' => 'VentaController@anular_asientos_preventa',
        'middleware' => 'can:ventas.ventas.anular_asientos_preventa'
    ]);


    
    $router->bind('detalleventa', function ($id) {
        return app('Modules\Ventas\Repositories\DetalleVentaRepository')->find($id);
    });
    $router->get('detalleventas', [
        'as' => 'admin.ventas.detalleventa.index',
        'uses' => 'DetalleVentaController@index',
        'middleware' => 'can:ventas.detalleventas.index'
    ]);
    $router->get('detalleventas/create', [
        'as' => 'admin.ventas.detalleventa.create',
        'uses' => 'DetalleVentaController@create',
        'middleware' => 'can:ventas.detalleventas.create'
    ]);
    $router->post('detalleventas', [
        'as' => 'admin.ventas.detalleventa.store',
        'uses' => 'DetalleVentaController@store',
        'middleware' => 'can:ventas.detalleventas.store'
    ]);
    $router->get('detalleventas/{detalleventa}/edit', [
        'as' => 'admin.ventas.detalleventa.edit',
        'uses' => 'DetalleVentaController@edit',
        'middleware' => 'can:ventas.detalleventas.edit'
    ]);
    $router->put('detalleventas/{detalleventa}', [
        'as' => 'admin.ventas.detalleventa.update',
        'uses' => 'DetalleVentaController@update',
        'middleware' => 'can:ventas.detalleventas.update'
    ]);
    $router->delete('detalleventas/{detalleventa}', [
        'as' => 'admin.ventas.detalleventa.destroy',
        'uses' => 'DetalleVentaController@destroy',
        'middleware' => 'can:ventas.detalleventas.destroy'
    ]);
    $router->bind('facturaventa', function ($id) 
    {
        return app('Modules\Ventas\Repositories\FacturaVentaRepository')->find($id);
    });
    $router->get('facturaventas', [
        'as' => 'admin.ventas.facturaventa.index',
        'uses' => 'FacturaVentaController@index',
        'middleware' => 'can:ventas.facturaventas.index'
    ]);
    $router->post('facturaventas/index_ajax', [
        'as' => 'admin.ventas.facturaventa.index_ajax',
        'uses' => 'FacturaVentaController@index_ajax',
        'middleware' => 'can:ventas.facturaventas.index_ajax'
    ]);

    $router->get('facturaventas/edit_nro_factura', [
        'as' => 'admin.ventas.facturaventa.edit_nro_factura',
        'uses' => 'FacturaVentaController@edit_nro_factura',
        'middleware' => 'can:ventas.facturaventas.edit_nro_factura'
    ]);

    $router->post('facturaventas/update_nro_factura', [
        'as' => 'admin.ventas.facturaventa.update_nro_factura',
        'uses' => 'FacturaVentaController@update_nro_factura',
        'middleware' => 'can:ventas.facturaventas.update_nro_factura'
    ]);

    $router->get('facturaventas/create', [
        'as' => 'admin.ventas.facturaventa.create',
        'uses' => 'FacturaVentaController@create',
        'middleware' => 'can:ventas.facturaventas.create'
    ]);
    $router->get('facturaventas/generar_facturas_vacias', [
        'as' => 'admin.ventas.facturaventa.generar_facturas_vacias',
        'uses' => 'FacturaVentaController@generar_facturas_vacias',
        'middleware' => 'can:ventas.facturaventas.generar_facturas_vacias'
    ]);

    $router->post('facturaventas/crear_facturas_vacias', [
        'as' => 'admin.ventas.facturaventa.crear_facturas_vacias',
        'uses' => 'FacturaVentaController@crear_facturas_vacias',
        'middleware' => 'can:ventas.facturaventas.crear_facturas_vacias'
    ]);
    
    $router->post('facturaventas', [
        'as' => 'admin.ventas.facturaventa.store',
        'uses' => 'FacturaVentaController@store',
        'middleware' => 'can:ventas.facturaventas.store'
    ]);
    $router->get('facturaventas/{facturaventa}/edit', [
        'as' => 'admin.ventas.facturaventa.edit',
        'uses' => 'FacturaVentaController@edit',
        'middleware' => 'can:ventas.facturaventas.edit'
    ]);
    $router->put('facturaventas/{facturaventa}', [
        'as' => 'admin.ventas.facturaventa.update',
        'uses' => 'FacturaVentaController@update',
        'middleware' => 'can:ventas.facturaventas.update'
    ]);
    $router->delete('facturaventas/{facturaventa}', [
        'as' => 'admin.ventas.facturaventa.destroy',
        'uses' => 'FacturaVentaController@destroy',
        'middleware' => 'can:ventas.facturaventas.destroy'
    ]);

    $router->bind('otras_ventas', function ($id) 
    {
        return Venta::find($id);
    });
    /*=======================OTRAS VENTAS=========================*/
    $router->get('ventas/otras_ventas', [
        'as' => 'admin.ventas.otras_ventas.index',
        'uses' => 'OtrasVentasController@index',
        'middleware' => 'can:ventas.ventas.index'
    ]);
    $router->post('otras_ventas/otras_ventas/index_ajax', [
            'as' => 'admin.ventas.otras_ventas.index_ajax',
            'uses' => 'OtrasVentasController@index_ajax',
            'middleware' => 'can:ventas.ventas.index'
        ]);


});
