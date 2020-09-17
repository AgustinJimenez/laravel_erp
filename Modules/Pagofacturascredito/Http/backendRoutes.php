<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/pagofacturascredito'], function (Router $router) {
    $router->bind('pagofacturacredito', function ($id) {
        return app('Modules\Pagofacturascredito\Repositories\PagofacturacreditoRepository')->find($id);
    });
    $router->get('pagofacturacreditos', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.index',
        'uses' => 'PagofacturacreditoController@index',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.index'
    ]);
    $router->post('pagofacturacreditos/index_ajax', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.index_ajax',
        'uses' => 'PagofacturacreditoController@index_ajax',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.index_ajax'
    ]);
    $router->get('pagofacturacreditos/create', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.create',
        'uses' => 'PagofacturacreditoController@create',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.create'
    ]);
    $router->post('pagofacturacreditos', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.store',
        'uses' => 'PagofacturacreditoController@store',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.store'
    ]);
    $router->get('pagofacturacreditos/{pagofacturacredito}/edit', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.edit',
        'uses' => 'PagofacturacreditoController@edit',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.edit'
    ]);
    $router->put('pagofacturacreditos/{pagofacturacredito}', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.update',
        'uses' => 'PagofacturacreditoController@update',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.update'
    ]);
    $router->get('pagofacturacreditos/{pagofacturacredito}', [
        'as' => 'admin.pagofacturascredito.pagofacturacredito.destroy',
        'uses' => 'PagofacturacreditoController@destroy',
        'middleware' => 'can:pagofacturascredito.pagofacturacreditos.destroy'
    ]);
// append

});
