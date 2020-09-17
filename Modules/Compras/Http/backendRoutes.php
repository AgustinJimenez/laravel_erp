<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/compras'], function (Router $router) {
    $router->bind('compra', function ($id) {
        return app('Modules\Compras\Repositories\CompraRepository')->find($id);
    });

    $router->get('compras', [
        'as' => 'admin.compras.compra.index',
        'uses' => 'CompraController@index',
        'middleware' => 'can:compras.compras.index'
    ]);

    $router->get('compras/pendientes', [
        'as' => 'admin.compras.compra.index_pendientes',
        'uses' => 'CompraController@index_pendientes',
        'middleware' => 'can:compras.compras.index_pendientes'
    ]);

    $router->get('compras/factura/{compra}', [
        'as' => 'admin.compras.compra.factura',
        'uses' => 'CompraController@factura',
        'middleware' => 'can:compras.compras.factura'
    ]);

    $router->post('compras/factura_update/{compra}', [
        'as' => 'admin.compras.compra.factura_update',
        'uses' => 'CompraController@factura_update',
        'middleware' => 'can:compras.compras.factura_update'
    ]);

    $router->get('compras/pago_create/{compra}', [
        'as' => 'admin.compras.compra.pago_create',
        'uses' => 'CompraController@pago_create',
        'middleware' => 'can:compras.compras.pago_create'
    ]);
    
    $router->post('compras/pagos/store', [
        'as' => 'admin.compras.compra.pago_store',
        'uses' => 'CompraController@pago_store',
        'middleware' => 'can:compras.compras.pago_store'
    ]);

    $router->post('compras/index_ajax', [
        'as' => 'admin.compras.compra.index_ajax',
        'uses' => 'CompraController@index_ajax',
        'middleware' => 'can:compras.compras.index_ajax'
    ]);

    $router->get('compras/create', [
        'as' => 'admin.compras.compra.create',
        'uses' => 'CompraController@create',
        'middleware' => 'can:compras.compras.create'
    ]);

    $router->get('compras/seleccion', [
        'as' => 'admin.compras.compra.seleccion',
        'uses' => 'CompraController@seleccion',
        'middleware' => 'can:compras.compras.seleccion'
    ]);
    $router->post('compras/update_config_factura/{config}', [
        'as' => 'admin.compras.compra.update_config_factura',
        'uses' => 'CompraController@update_config_factura',
        'middleware' => 'can:compras.compras.update_config_factura'
    ]);
    $router->get('compras/edit_config_factura', [
        'as' => 'admin.compras.compra.edit_config_factura',
        'uses' => 'CompraController@edit_config_factura',
        'middleware' => 'can:compras.compras.edit_config_factura'
    ]);

    $router->post('compras/cuenta_change', [
        'as' => 'admin.compras.compra.cuenta_change',
        'uses' => 'CompraController@cuenta_change',
        'middleware' => 'can:compras.compras.cuenta_change'
    ]);

    $router->post('compras', [
        'as' => 'admin.compras.compra.store',
        'uses' => 'CompraController@store',
        'middleware' => 'can:compras.compras.store'
    ]);
    /*---------------------Reporte de Gastos-------------------------------*/
    
    $router->get('compras/reporte_gastos_performance', [
        'as' => 'admin.compras.compra.reporte_gastos_performance',
        'uses' => 'CompraController@reporte_gastos_performance',
        'middleware' => 'can:compras.compras.reporte_gastos_performance'
    ]);

     $router->get('compras/reporte_gastos', [
        'as' => 'admin.compras.compra.reporte_gastos',
        'uses' => 'CompraController@reporte_gastos',
        'middleware' => 'can:compras.compras.reporte_gastos'
    ]);

     $router->post('compras/reporte_gastos_ajax', [
        'as' => 'admin.compras.compra.reporte_gastos_ajax',
        'uses' => 'CompraController@reporte_gastos_ajax',
        'middleware' => 'can:compras.compras.reporte_gastos_ajax'
    ]);

    $router->post('compras/categorias_reporte_gastos_ajax', [
        'as' => 'admin.compras.compra.categorias_reporte_gastos_ajax',
        'uses' => 'CompraController@categorias_reporte_gastos_ajax',
        'middleware' => 'can:compras.compras.categorias_reporte_gastos_ajax'
    ]); 

    $router->get('compras/categorias_reporte_xls', [
        'as' => 'admin.compras.compra.categorias_reporte_xls',
        'uses' => 'CompraController@categorias_reporte_xls',
        'middleware' => 'can:compras.compras.categorias_reporte_xls'
    ]);

    $router->get('compras/reporte_xls', [
        'as' => 'admin.compras.compra.reporte_xls',
        'uses' => 'CompraController@reporte_xls',
        'middleware' => 'can:compras.compras.reporte_xls'
    ]);

    $router->get('compras/query_reporte_categoria', [
        'as' => 'admin.compras.query_reporte_categoria.reporte_xls',
        'uses' => 'CompraController@query_reporte_categoria',
        'middleware' => 'can:compras.compras.query_reporte_categoria'
    ]);

    $router->get('compras/query_reporte', [
        'as' => 'admin.compras.compra.query_reporte',
        'uses' => 'CompraController@query_reporte',
        'middleware' => 'can:compras.compras.query_reporte'
    ]);

    /*----------------------Reporte de Gastos------------------------------*/
    $router->get('compras/{compra}/edit', [
        'as' => 'admin.compras.compra.edit',
        'uses' => 'CompraController@edit',
        'middleware' => 'can:compras.compras.edit'
    ]);

    $router->put('compras/{compra}', [
        'as' => 'admin.compras.compra.update',
        'uses' => 'CompraController@update',
        'middleware' => 'can:compras.compras.update'
    ]);
    $router->delete('compras/{compra}', [
        'as' => 'admin.compras.compra.destroy',
        'uses' => 'CompraController@destroy',
        'middleware' => 'can:compras.compras.destroy'
    ]);
    $router->bind('detallecompra', function ($id) 
    {
        return app('Modules\Compras\Repositories\DetallecompraRepository')->find($id);
    });
    $router->get('detallecompras', [
        'as' => 'admin.compras.detallecompra.index',
        'uses' => 'DetallecompraController@index',
        'middleware' => 'can:compras.detallecompras.index'
    ]);
    $router->get('detallecompras/create', [
        'as' => 'admin.compras.detallecompra.create',
        'uses' => 'DetallecompraController@create',
        'middleware' => 'can:compras.detallecompras.create'
    ]);
    $router->post('detallecompras', [
        'as' => 'admin.compras.detallecompra.store',
        'uses' => 'DetallecompraController@store',
        'middleware' => 'can:compras.detallecompras.store'
    ]);
    $router->get('detallecompras/{detallecompra}/edit', [
        'as' => 'admin.compras.detallecompra.edit',
        'uses' => 'DetallecompraController@edit',
        'middleware' => 'can:compras.detallecompras.edit'
    ]);
    $router->put('detallecompras/{detallecompra}', [
        'as' => 'admin.compras.detallecompra.update',
        'uses' => 'DetallecompraController@update',
        'middleware' => 'can:compras.detallecompras.update'
    ]);
    $router->delete('detallecompras/{detallecompra}', [
        'as' => 'admin.compras.detallecompra.destroy',
        'uses' => 'DetallecompraController@destroy',
        'middleware' => 'can:compras.detallecompras.destroy'
    ]);
    $router->bind('pago', function ($id) 
    {
        return app('Modules\Compras\Entities\CompraPago')->find($id);
    });
    /*==================DESTROYPAGO========================*/
    $router->get('comprapago/delete_pago/{pago}', [
        'as' => 'admin.compras.comprapago.destroypago',
        'uses' => 'CompraPagoController@destroypago',
        'middleware' => 'can:compras.detallecompras.edit'
    ]);
// append


});
