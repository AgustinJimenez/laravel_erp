<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/clientes'], function (Router $router) {
    $router->bind('cliente', function ($id) {
        return app('Modules\Clientes\Repositories\ClienteRepository')->find($id);
    });
    $router->get('clientes', [
        'as' => 'admin.clientes.cliente.index',
        'uses' => 'ClienteController@index',
        'middleware' => 'can:clientes.clientes.index'
    ]);
    $router->get('clientes/search_cliente', [
        'as' => 'admin.clientes.cliente.search_cliente',
        'uses' => 'ClienteController@search_cliente',
        'middleware' => 'can:clientes.clientes.search_cliente'
    ]);

    $router->get('clientes/upload_cliente_xls', [
        'as' => 'admin.clientes.cliente.upload_cliente_xls',
        'uses' => 'ClienteController@upload_cliente_xls',
        'middleware' => 'can:clientes.clientes.upload_cliente_xls'
    ]);

    $router->post('clientes/upload_cliente_xls_store', [
        'as' => 'admin.clientes.cliente.upload_cliente_xls_store',
        'uses' => 'ClienteController@upload_cliente_xls_store',
        'middleware' => 'can:clientes.clientes.upload_cliente_xls_store'
    ]);

    $router->get('clientes/descargar_ejemplo', [
        'as' => 'admin.clientes.cliente.descargar_ejemplo',
        'uses' => 'ClienteController@descargar_ejemplo',
        'middleware' => 'can:clientes.clientes.descargar_ejemplo'
    ]);

    $router->post('clientes/index_ajax', [
        'as' => 'admin.clientes.cliente.index_ajax',
        'uses' => 'ClienteController@index_ajax',
        'middleware' => 'can:clientes.clientes.index_ajax'
    ]);
    
    $router->get('clientes/create', [
        'as' => 'admin.clientes.cliente.create',
        'uses' => 'ClienteController@create',
        'middleware' => 'can:clientes.clientes.create'
    ]);
    $router->post('clientes', [
        'as' => 'admin.clientes.cliente.store',
        'uses' => 'ClienteController@store',
        'middleware' => 'can:clientes.clientes.store'
    ]);
    $router->get('clientes/{cliente}/edit', [
        'as' => 'admin.clientes.cliente.edit',
        'uses' => 'ClienteController@edit',
        'middleware' => 'can:clientes.clientes.edit'
    ]);
    $router->put('clientes/{cliente}', [
        'as' => 'admin.clientes.cliente.update',
        'uses' => 'ClienteController@update',
        'middleware' => 'can:clientes.clientes.update'
    ]);
    $router->delete('clientes/{cliente}', [
        'as' => 'admin.clientes.cliente.destroy',
        'uses' => 'ClienteController@destroy',
        'middleware' => 'can:clientes.clientes.destroy'
    ]);
// append

});
