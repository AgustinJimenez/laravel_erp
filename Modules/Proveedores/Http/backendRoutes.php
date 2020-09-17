<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/proveedores'], function (Router $router) {
    $router->bind('proveedor', function ($id) {
        return app('Modules\Proveedores\Repositories\ProveedorRepository')->find($id);
    });
    $router->get('proveedors', [
        'as' => 'admin.proveedores.proveedor.index',
        'uses' => 'ProveedorController@index',
        'middleware' => 'can:proveedores.proveedors.index'
    ]);

    $router->get('proveedors/search_proveedor', [
        'as' => 'admin.proveedores.proveedor.search_proveedor',
        'uses' => 'ProveedorController@search_proveedor',
        'middleware' => 'can:proveedores.proveedors.search_proveedor'
    ]);

    $router->post('proveedors/indexAjax', [
        'as' => 'admin.proveedores.proveedor.indexAjax',
        'uses' => 'ProveedorController@indexAjax',
        'middleware' => 'can:proveedores.proveedors.indexAjax'
    ]);

    $router->get('proveedors/create', [
        'as' => 'admin.proveedores.proveedor.create',
        'uses' => 'ProveedorController@create',
        'middleware' => 'can:proveedores.proveedors.create'
    ]);
    $router->post('proveedors', [
        'as' => 'admin.proveedores.proveedor.store',
        'uses' => 'ProveedorController@store',
        'middleware' => 'can:proveedores.proveedors.store'
    ]);
    $router->get('proveedors/{proveedor}/edit', [
        'as' => 'admin.proveedores.proveedor.edit',
        'uses' => 'ProveedorController@edit',
        'middleware' => 'can:proveedores.proveedors.edit'
    ]);
    $router->put('proveedors/{proveedor}', [
        'as' => 'admin.proveedores.proveedor.update',
        'uses' => 'ProveedorController@update',
        'middleware' => 'can:proveedores.proveedors.update'
    ]);
    $router->delete('proveedors/{proveedor}', [
        'as' => 'admin.proveedores.proveedor.destroy',
        'uses' => 'ProveedorController@destroy',
        'middleware' => 'can:proveedores.proveedors.destroy'
    ]);
// append

});
